# Компоненты страницы - php реализация

Компонент - это когда код генерации html (например, шаблон) а также стили и скрипты от какой-то части страницы собраны вместе и лежат в одной папке.

Компонент решает следующие задачи:

- Явные контракты компонентов. Каждый компонент должен иметь описание того, как он выглядит и работает.
- Изоляция стилей. Когда стили пишутся и лежат отдельно от выдачи (т.е. как делается обычно) - они пишутся для того контекста, в котором компонент разрабатывается. При переносе компонента в другой контекст (например, из контента страницы в правую колонку) стили часто ломаются. Кроме того, стили отдельного компонента сложно выделить из общей каскадной каши. Вынесение стилей компонента в отдельный файл должно искоренить использование контекста в стилях.
- Защита от конфликтов css-классов. Каждый компонент использует уникальный корневой css-класс, от которого пишутся все его стили.
- Упрощение доступа разработчиков к стилям и скриптам - они лежат рядом с шаблоном.

Чтобы создать компонент, нужно написать php-класс, который будет точкой доступа ко всему функционалу компонента. Т.е. этот класс должен иметь:

- метод рисования компонента, например render() или html()
- методы getCssPath() и getJsPath(), которые возвращают пути к файлам css и js компонента
- Файлы css и js компонента используются только сборщиком агрегатов.

# Как использовать модуль в проекте

Сначала нужно подключить модуль в composer.conf и обновить composer.

После этого можно создавать первый компонент. Например, создаем в проекте папку Components/HeaderComponent и в нее кладем следующие файлы:

HeaderComponent.php

    <?php

    namespace Components\HeaderComponent;

    use OLOG\Component\ComponentTrait;
    use OLOG\Component\InterfaceComponent;

    class HeaderComponent implements InterfaceComponent
    {
        use ComponentTrait;

        static public function render()
        {
            $_component_class = \OLOG\Component\GenerateCSS::getCssClassName(__CLASS__);

            ?>
            <h1 class="<?= $_component_class ?>">PAGE HEADER</h1>
            <?php
        }
    }

styles.less

    ._COMPONENT_CLASS {
      font-size: 24px;
      background-color: #eee;
    }

scripts.js - пустой

Потом надо зарегистрировать компонент в сборщике. Добавляем в конфигурацию следующий раздел:

    $conf['component_classes_arr'] = [
        HeaderComponent::class
    ];

И разрешить сборку JS и CSS файлов в конфиге:

    $conf[\OLOG\Component\ComponentConstants::MODULE_NAME] = new \OLOG\Component\ComponentConfig(true, true);

После этого можно выполнять сборщик. Самый простой вариант выполнения сборщика - включить его в index.php, тогда агрегаты будут пересобираться при каждом запросе к сайту.

    <?php

    require_once '../vendor/autoload.php';

    \OLOG\ConfWrapper::assignConfig(\PHPComponentsDemo\ComponentsDemoConfig::get());

    \OLOG\Component\GenerateCSS::generateCSS();
    \OLOG\Component\GenerateJS::generateJS();

    \PHPComponentsDemo\DemoLayout\DemoLayoutComponent::render();

И наконец подключаем готовые агрегаты в шаблоне:

    <link href="/assets/common.css" rel="stylesheet"/>

# Дополнительный функционал

## Трейт компонента

Содержит дефолтную реализацию методов getCssPath() и getJsPath() - они возвращают пути к файлам соответственно styles.less и scripts.js в папке класса компонента. Т.е. если подключить этот трейт к классу компонента - в классе нужно будет реализовать только метод рендера.

## Инкапсуляция стилей (уникальный идентификатор класса компонента)

В файле стилей можно использовать константу _COMPONENT_CLASS - сборщик заменит ее на закодированное имя класса компонента. это значение уникально среди всех компонентов и может использоваться как имя css класса для корневого контейнера компонента.

Точно такое же закодированное имя класса компонента доступно в коде генерации компонента через \OLOG\Component\GenerateCSS::getCssClassName(__CLASS__) (чтобы назначить этот класс корневому контейнеру).

## Уникальный идентификатор экземпляра компонента

Можно получить в коде генерации компонента через \OLOG\Component\GenerateJS::generateComponentInstanceId().

Можно использовать для присвоения контейнеру компонента уникального id с тем, чтобы получать доступ к контейнеру в js.
