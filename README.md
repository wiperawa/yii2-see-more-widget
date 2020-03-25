# yii2-see-more-widget
widget that cut off html content to predefined height, and display ...see more link

## Installation
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require wiperawa/yii2-see-more-widget "dev-master"
```

or add

```
"wiperawa/yii2-copy-to-clipboard-widget": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Usage
```
use \wiperawa\seemore\SeeMoreWidget;

SeeMoreWidget::begin([
    'height' => 160 //height of cutoff container in pixels
    //'containerOptions' => [], //Html attributes of container
    //'btnOptions => [], //Html attributes of buttons
    //'showMoreLabel' => '...(see more)',
    //'showLessLabel' => '(less)',
    //'opened' => false //Show allready opened
    //''
]);
    ....Some HTML goes here....
    ...........................
    ...........................
SeeMoreWidget::end()



```