<?php

namespace Business\Calculator;

use PHPUnit\Framework\TestCase;
use Ps\Business\AppBusinessFactory;
use Ps\Business\CountryReader\CountryReaderInterface;
use Ps\Business\RateReader\RateReaderInterface;
use Ps\Shared\PaymentTransfer;

/**
 * @hint Ideally all Business Models and all scenarios should be covered by tests. But, as we have many of them, I implemented only calculation test coverage as an example.
 */
class CommissionCalculatorTest extends TestCase
{
    /**
     * @var string
     */
    private const COUNTRY_EU = 'DK';

    /**
     * @var string
     */
    private const COUNTRY_NON_EU = 'JP';

    /**
     * @var string
     */
    private const CURRENCY_EUR = 'EUR';

    /**
     * @var string
     */
    private const CURRENCY_NON_EUR = 'USD';

    /**
     * @var string
     */
    private const DEFAULT_AMOUNT = 100;

    /**
     * @return void
     */
    public function testCommissionCalculatorShouldCalculateEuCoefficientForEuCountry(): void
    {
        // Arrange
        $appBusinessFactoryMock = $this->createAppBusinessFactoryMock(
            $this->createCountryReaderMock(static::COUNTRY_EU),
            $this->createRateReaderMock(1),
        );

        // Act
        $paymentTransfer = $this->calculateCommission($appBusinessFactoryMock);

        // Assert
        $this->assertSame(1.0, $paymentTransfer->getCommissionOrFail());
    }

    /**
     * @return void
     */
    public function testCommissionCalculatorShouldCalculateNonEuCoefficientForNonEuCountry(): void
    {
        // Arrange
        $appBusinessFactoryMock = $this->createAppBusinessFactoryMock(
            $this->createCountryReaderMock(static::COUNTRY_NON_EU),
            $this->createRateReaderMock(1),
        );

        // Act
        $paymentTransfer = $this->calculateCommission($appBusinessFactoryMock);

        // Assert
        $this->assertSame(2.0, $paymentTransfer->getCommissionOrFail());
    }

    /**
     * @return void
     */
    public function testCommissionCalculatorShouldIgnoreRateForEuCountry(): void
    {
        // Arrange
        $appBusinessFactoryMock = $this->createAppBusinessFactoryMock(
            $this->createCountryReaderMock(static::COUNTRY_EU),
            $this->createRateReaderMock(2),
        );

        // Act
        $paymentTransfer = $this->calculateCommission($appBusinessFactoryMock);

        // Assert
        $this->assertSame(1.0, $paymentTransfer->getCommissionOrFail());
    }

    /**
     * @return void
     */
    public function testCommissionCalculatorShouldIgnoreRateForEurCurrency(): void
    {
        // Arrange
        $appBusinessFactoryMock = $this->createAppBusinessFactoryMock(
            $this->createCountryReaderMock(static::COUNTRY_EU),
            $this->createRateReaderMock(2),
        );

        // Act
        $paymentTransfer = $this->calculateCommission($appBusinessFactoryMock);

        // Assert
        $this->assertSame(1.0, $paymentTransfer->getCommissionOrFail());
    }

    /**
     * @return void
     */
    public function testCommissionCalculatorShouldIgnoreRateWhenRateIsZero(): void
    {
        // Arrange
        $appBusinessFactoryMock = $this->createAppBusinessFactoryMock(
            $this->createCountryReaderMock(static::COUNTRY_EU),
            $this->createRateReaderMock(0),
        );

        // Act
        $paymentTransfer = $this->calculateCommission($appBusinessFactoryMock, static::CURRENCY_NON_EUR);

        // Assert
        $this->assertSame(1.0, $paymentTransfer->getCommissionOrFail());
    }

    /**
     * @return void
     */
    public function testCommissionCalculatorShouldCalculateRateForNonEurCurrency(): void
    {
        // Arrange
        $appBusinessFactoryMock = $this->createAppBusinessFactoryMock(
            $this->createCountryReaderMock(static::COUNTRY_NON_EU),
            $this->createRateReaderMock(4),
        );

        // Act
        $paymentTransfer = $this->calculateCommission($appBusinessFactoryMock);

        // Assert
        $this->assertSame(0.5, $paymentTransfer->getCommissionOrFail());
    }

    /**
     * @return void
     */
    public function testCommissionCalculatorShouldCeilResult(): void
    {
        // Arrange
        $appBusinessFactoryMock = $this->createAppBusinessFactoryMock(
            $this->createCountryReaderMock(static::COUNTRY_NON_EU),
            $this->createRateReaderMock(1.11),
        );

        // Act
        $paymentTransfer = $this->calculateCommission($appBusinessFactoryMock, static::CURRENCY_NON_EUR);

        // Assert
        $this->assertSame(1.81, $paymentTransfer->getCommissionOrFail());
    }

    /**
     * @param \Ps\Business\AppBusinessFactory $appBusinessFactoryMock
     * @param string|null $currency
     *
     * @return \Ps\Shared\PaymentTransfer
     */
    private function calculateCommission(AppBusinessFactory $appBusinessFactoryMock, ?string $currency = null): PaymentTransfer
    {
        $paymentTransfer = $this->createPaymentTransfer($currency ?? static::CURRENCY_EUR);

        return $appBusinessFactoryMock->createCommissionCalculator()->calculateCommission($paymentTransfer);
    }

    /**
     * @param string $currency
     *
     * @return \Ps\Shared\PaymentTransfer
     */
    private function createPaymentTransfer(string $currency): PaymentTransfer
    {
        return (new PaymentTransfer())
            ->setAmount(static::DEFAULT_AMOUNT)
            ->setCurrency($currency);
    }

    /**
     * @param \Ps\Business\CountryReader\CountryReaderInterface $countryReaderMock
     * @param \Ps\Business\RateReader\RateReaderInterface $rateReaderMock
     *
     * @return \Ps\Business\AppBusinessFactory
     */
    private function createAppBusinessFactoryMock(
        CountryReaderInterface $countryReaderMock,
        RateReaderInterface $rateReaderMock
    ): AppBusinessFactory {
        $appBusinessFactoryMock = $this->getMockBuilder(AppBusinessFactory::class)
            ->onlyMethods(['createCountryReader', 'createRateReader'])
            ->getMock();
        $appBusinessFactoryMock
            ->method('createCountryReader')
            ->willReturn($countryReaderMock);
        $appBusinessFactoryMock
            ->method('createRateReader')
            ->willReturn($rateReaderMock);

        return $appBusinessFactoryMock;
    }

    /**
     * @param string $country
     *
     * @return \Ps\Business\CountryReader\CountryReaderInterface
     */
    private function createCountryReaderMock(string $country): CountryReaderInterface
    {
        $countryReaderMock = $this->getMockBuilder(CountryReaderInterface::class)->getMock();
        $countryReaderMock
            ->expects($this->once())
            ->method('getCountry')
            ->willReturn($country);

        return $countryReaderMock;
    }

    /**
     * @param float $rate
     *
     * @return \Ps\Business\RateReader\RateReaderInterface
     */
    private function createRateReaderMock(float $rate): RateReaderInterface
    {
        $rateReaderMock = $this->getMockBuilder(RateReaderInterface::class)->getMock();
        $rateReaderMock
            ->expects($this->once())
            ->method('getRate')
            ->willReturn($rate);

        return $rateReaderMock;
    }
}
