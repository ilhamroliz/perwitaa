<?php

namespace App\pagination;

use Illuminate\Pagination\BootstrapThreePresenter;
use Illuminate\Support\HtmlString;


class CustomPresenter  extends BootstrapThreePresenter{
      public function render()
    {
        if( ! $this->hasPages())
            return '';

        return sprintf(
            '<ul class="pagination" aria-label="Pagination">%s %s %s</ul></div>',
            $this->getPreviousButton(),
            $this->getLinks(),
            $this->getNextButton()
        );
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<li class="unavailable" aria-disabled="true"><a href="javascript:void(0)">'.$text.'</a></li>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<li class="current"><a href="javascript:void(0)">'.$text.'</a></li>';
    }

    /**
     * Get a pagination "dot" element.
     *
     * @return string
     */
    protected function getDots()
    {
        return $this->getDisabledTextWrapper('&hellip;');
    }
 
} 