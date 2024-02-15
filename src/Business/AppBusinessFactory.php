<?php

namespace Ps\Business;

use Ps\Business\Application\Application;
use Ps\Business\Calculator\CommissionCalculator;
use Ps\Business\Calculator\CommissionCalculatorInterface;
use Ps\Business\Calculator\Steps\CeilCommissionCalculatorStep;
use Ps\Business\Calculator\Steps\CommissionCalculatorStepInterface;
use Ps\Business\Calculator\Steps\FixedAmountCommissionCalculatorStep;
use Ps\Business\Calculator\Steps\RateCommissionCalculatorStep;
use Ps\Business\CountryReader\CountryReaderInterface;
use Ps\Business\CountryReader\FileCountryReader;
use Ps\Business\Decoder\DecoderInterface;
use Ps\Business\Decoder\JsonDecoder;
use Ps\Business\FileReader\FileReader;
use Ps\Business\FileReader\FileReaderInterface;
use Ps\Business\Input\Input;
use Ps\Business\Input\InputInterface;
use Ps\Business\Mapper\Mapper;
use Ps\Business\Mapper\MapperInterface;
use Ps\Business\Output\Output;
use Ps\Business\Output\OutputInterface;
use Ps\Business\RateReader\FileRateReader;
use Ps\Business\RateReader\RateCacher;
use Ps\Business\RateReader\RateCacherInterface;
use Ps\Business\RateReader\RateReaderInterface;
use Ps\Business\Validator\PaymentValidator;
use Ps\Business\Validator\Rules\AmountIsFloatValidationRule;
use Ps\Business\Validator\Rules\BinContainsFourDigitsValidationRule;
use Ps\Business\Validator\Rules\CurrencyContainsThreeLettersValidationRule;
use Ps\Business\Validator\ValidatorInterface;

class AppBusinessFactory
{
    /**
     * @return \Ps\Business\Application\Application
     */
    public function createApplication(): Application
    {
        return new Application(
            $this->createOutput(),
            $this->createMapper(),
            $this->createDecoder(),
            $this->createFileReader(),
            $this->createPaymentValidator(),
            $this->createCommissionCalculator(),
        );
    }

    /**
     * @return \Ps\Business\Input\InputInterface
     */
    public function createInput(): InputInterface
    {
        return new Input();
    }

    /**
     * @return \Ps\Business\Output\OutputInterface
     */
    public function createOutput(): OutputInterface
    {
        return new Output();
    }

    /**
     * @return \Ps\Business\FileReader\FileReaderInterface
     */
    public function createFileReader(): FileReaderInterface
    {
        return new FileReader();
    }

    /**
     * @return \Ps\Business\Decoder\DecoderInterface
     */
    public function createDecoder(): DecoderInterface
    {
        return new JsonDecoder();
    }

    /**
     * @return \Ps\Business\Mapper\MapperInterface
     */
    public function createMapper(): MapperInterface
    {
        return new Mapper();
    }

    /**
     * @return \Ps\Business\RateReader\RateReaderInterface
     */
    public function createRateReader(): RateReaderInterface
    {
        return new FileRateReader(
            $this->createRateCacher(),
        );
    }

    /**
     * @return \Ps\Business\RateReader\RateCacherInterface
     */
    public function createRateCacher(): RateCacherInterface
    {
        return new RateCacher();
    }

    /**
     * @return \Ps\Business\Calculator\CommissionCalculatorInterface
     */
    public function createCommissionCalculator(): CommissionCalculatorInterface
    {
        return new CommissionCalculator([
            $this->createFixedAmountCommissionCalculatorStep(),
            $this->createRateCommissionCalculatorStep(),
            $this->createCeilCommissionCalculatorStep(),
        ]);
    }

    /**
     * @return \Ps\Business\Calculator\Steps\CommissionCalculatorStepInterface
     */
    public function createFixedAmountCommissionCalculatorStep(): CommissionCalculatorStepInterface
    {
        return new FixedAmountCommissionCalculatorStep(
            $this->createRateReader(),
        );
    }

    /**
     * @return \Ps\Business\Calculator\Steps\CommissionCalculatorStepInterface
     */
    public function createRateCommissionCalculatorStep(): CommissionCalculatorStepInterface
    {
        return new RateCommissionCalculatorStep(
            $this->createCountryReader(),
        );
    }

    /**
     * @return \Ps\Business\CountryReader\CountryReaderInterface
     */
    public function createCountryReader(): CountryReaderInterface
    {
        return new FileCountryReader();
        //return new BinListCountryReader();
    }

    /**
     * @return \Ps\Business\Calculator\Steps\CommissionCalculatorStepInterface
     */
    public function createCeilCommissionCalculatorStep(): CommissionCalculatorStepInterface
    {
        return new CeilCommissionCalculatorStep();
    }

    /**
     * @return \Ps\Business\Validator\ValidatorInterface
     */
    public function createPaymentValidator(): ValidatorInterface
    {
        return new PaymentValidator([
            new AmountIsFloatValidationRule(),
            new BinContainsFourDigitsValidationRule(),
            new CurrencyContainsThreeLettersValidationRule(),
        ]);
    }
}
