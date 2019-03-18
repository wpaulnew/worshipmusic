<?php

namespace vendor\core;

// https://code-live.ru/post/php-ajax-registration/

class View
{
  public $layout = "template";
  public $description = "description";
  public $author = "author";
  public $keywords = "keywords";
  public $menu = "default";
  public $footer = "default";
  public $numbers = ["62", "25", "81"];
  public $container = [];

//  // Отделить скрипты от кода
  public function unScript($template)
  {
    return preg_match('(<script>(.*)<\/script>)', $this->fetchPartial($template, $params), $script);
  }

  // Получить отрендеренный шаблон с параметрами $params
  public function fetchPartial($template, $params = array())
  {
    extract($params);
    ob_start();

    require_once(VIEWS . '/' . $template . '.php');

    return ob_get_clean();
  }

  // Получить отрендеренный в переменную $content layout-а
  // Шаблон с параметрами $params
  public function fetch($template, $params = array())
  {
    $content = $this->fetchPartial($template, $params);

    // Здесь лежат стили и скрипты
    $container = [];

    // Находим javascript
    $scriptpattern = "#<script(.*?)>.*?</script>#si";
    preg_match_all($scriptpattern, $content, $scripts);

    // Находим стили
    $stylepattern = "#<style(.*?)>.*?</style>#si";
    preg_match_all($stylepattern, $content, $styles);

    if (!empty($scripts)) {
      $this->container["scripts"] = $scripts[0];
      $content = preg_replace($scriptpattern, "", $content);
    }

    if (!empty($styles)) {
      $this->container["styles"] = $styles[0];
      $content = preg_replace($stylepattern, "", $content);
    }

    return $this->fetchPartial($this->layout, array(
        'description' => $this->description,
        'author' => $this->author,
        'keywords' => $this->keywords,

        'content' => $content,
        'container' => $this->container,

        'menu' => $this->menu,
        'footer' => $this->footer,

        'numbers' => $this->numbers
      )
    );
  }

  // вывести отрендеренный в переменную $content layout-а
  // шаблон с параметрами $params
  public function render($template, $params = array())
  {
    echo $this->fetch($template, $params);
  }
}