<?php

namespace wiperawa\seemore;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\i18n\PhpMessageSource;

/**
 * SeeMoreWidget to cut off some big text/html, and add 'See  more' link to expand complete text .
 * usage:
 * SeeMoreWidget::begin();
 * ....Some html goes here...
 * SeeMoreWidget::end();
 *
 * Class SeeMoreWidget
 * @package common\widgets
 */
class SeeMoreWidget extends Widget
{

    /**
     * Html options for content container
     * @var array
     */
    public $containerOptions = [];

    /**
     * Buttons html options
     * @var array
     */
    public $btnOptions = [
        'style' => [
            'margin' => '10px 0',
        ]
    ];

    /**
     * Rendered state, container allready open or not.
     * @var bool
     */
    public $opened = false;

    /**
     * shorten container height
     * @var int
     */
    public $containerHeight = 160;

    /**
     * Show label text
     * @var string
     */
    public $showMoreLabel = '...(see more)';

    /**
     * less label text
     * @var string
     */
    public $showLessLabel = '(less)';


    /**
     * Default content container options
     * @var array
     */
    protected $defaultContainerOptions = [
        'style' => [
            'overflow' => 'hidden',
        ],
    ];


    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        ob_start();
    }

    /**
     * {@inheritDoc}
     * @return string|void
     */
    public function run()
    {

        $content = ob_get_contents();
        ob_end_clean();

        $moreBtnId = $this->getId() . '-more-btn';
        $lessBtnId = $this->getId() . '-less-btn';
        $containerId = $this->getId() . '-container';
        $lessBtnLabel = Yii::t($this->_msgCategory, $this->showLessLabel);
        $moreBtnLabel = Yii::t($this->_msgCategory, $this->showMoreLabel);

        if (!$this->opened) {
            $this->defaultContainerOptions['style']['max-height'] = $this->containerHeight . 'px';
        }

        echo Html::tag(
            'div',
            $content,
            ArrayHelper::merge(
                ['id' => $containerId],
                $this->containerOptions,
                $this->defaultContainerOptions)
        );

        echo Html::a($moreBtnLabel, '', ArrayHelper::merge($this->btnOptions, [
            'style' => [
                'display' => 'none',
            ],
            'id' => $moreBtnId,
            'onClick' => new JsExpression("
                $('#{$containerId}').css({'max-height': ''}); 
                $('#{$lessBtnId}').show();$(this).hide(); 
                return false; 
            ")
        ]));
        echo Html::a($lessBtnLabel, '#', ArrayHelper::merge($this->btnOptions, [
            'style' => [
                'display' => 'none',
            ],
            'id' => $lessBtnId,
            'onClick' => new JsExpression("
                $('#{$containerId}').css({'max-height': '{$this->containerHeight}px'}); 
                $('#{$moreBtnId}').show();
                $(this).hide();
            ")
        ]));

        $opened = json_encode($this->opened);

        $this->getView()->registerJs("
            if ( $('#{$containerId}').height() >= {$this->containerHeight}) { 
                if ({$opened} == true) {
                    $('#{$lessBtnId}').show();
                } else {
                    $('#{$moreBtnId}').show();
                }
            } 
        ");
    }


}