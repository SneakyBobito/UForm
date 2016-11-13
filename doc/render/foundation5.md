---
currentMenu: rendering
---

Foundation 5 Render
==================

UForm allows to render for foundation 5:

```php

    use UForm\Render\Html\Foundation5;

    $render = new Foundation5();
    $html = $render->render($formContext);

```


Additional CSS
--------------

Some additional css is required to make the render of foundation 5 render better.

Up to you to modify the following sample to adapt it to your theme.


```css
  /** Highlight tabs with errors **/
  .tab-title.error a,
  .tab-title.active.error a{
      color: #E26464;
  }
  .tab-title.error a,
  .tab-title.error.active a,
  .tab-title.error.active:hover a{

      background: #FFEDEC;
  }
  .tab-title.error:hover a{
      background: #FABEBB;
  }

  /** bootstrap's like panels for foundation **/
  .form-panel{
      border: 1px solid #DDD;
      margin: 10px 0 5px 0;
  }
  .form-panel .panel-heading{
      background: #FAFAFA;
      padding: 5px 8px;
      border-bottom: 1px solid #DDD;
  }

  .form-panel .panel-body{
      padding: 5px;
  }

  /** foundation tab border **/
  .tabs-content{
      border-left: 1px solid #DDD;
      padding-left: 8px;
  }
  .tabs{
      border-bottom:1px solid #DDD;
  }
  .tabs>dd{
      position: relative;
      top:2px;
  }
  .tabs>dd.active{
      border-bottom: 1px solid #FFF;
      border-left: 1px solid #DDD;
      border-top: 1px solid #DDD;
      border-right: 1px solid #DDD;
  }
  .tabs>dd.active>a.has-tip{
      border:0;
  }

  /** remove tab outline **/
  .tabs dd > a{
      outline: 0;
  }


  /** foundation 5 does not implement help text **/
  .help-text{
      color: #888;
      font-size: 0.8em;
  }
  .input-single .help-text{
      position: relative;
      top: -15px;
  }

  .tabs-content>.content>.help-text{
      margin-bottom: 5px;;
  }

```

Additional Javascript
---------------------

Some component need additional javascript to run properly:

```js
$(function(){
    // you need to call this everytime you add a form to the dom
    $(document).foundation();
});
```

Note: If you load a form via ajax you need to run this javascript again on the loaded html

More informations available on the [foundation doc](http://foundation.zurb.com/docs/javascript.html)
