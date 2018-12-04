<?php

namespace App\Cart;

use Money\Currency;
use Money\Money as BaseMoney;
use Money\Currencies\ISOCurrencies;
use NumberFormatter;
use Money\Formatter\IntlMoneyFormatter;

class Money
{
    protected $money;

    /**
     * Money constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->money = new BaseMoney($value, new Currency('GBP'));
    }

    /**
     * @return string
     */
    public function amount()
    {
        return $this->money->getAmount();
    }

    /**
     * @return string
     */
    public function formatted()
    {
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter('en_GB', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $formatter->format($this->money);
    }
}
