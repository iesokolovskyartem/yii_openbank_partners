# Пакет для интеграции с партнерским кабинетом банка Открытие с помощью API.

[![Latest Stable Version](https://poser.pugx.org/iesokolovskyartem/yii_openbank_partners/v)](//packagist.org/packages/iesokolovskyartem/yii_openbank_partners)
[![Latest Unstable Version](https://poser.pugx.org/iesokolovskyartem/yii_openbank_partners/v/unstable)](//packagist.org/packages/iesokolovskyartem/yii_openbank_partners)
[![Total Downloads](https://poser.pugx.org/iesokolovskyartem/yii_openbank_partners/downloads)](//packagist.org/packages/iesokolovskyartem/yii_openbank_partners)
[![License](https://poser.pugx.org/iesokolovskyartem/yii_openbank_partners/license)](//packagist.org/packages/iesokolovskyartem/yii_openbank_partners)

### Введение

Этот пакет написан не разработчиком банка Открытия, разработан для [Framework yii2](https://www.yiiframework.com/).
Документацию по пакету можно найти в [WiKi страницах](https://github.com/iesokolovskyartem/yii_openbank_partners/wiki), техническую поддержку можно получить написав 
на почту [artem@sokolovsky.eu](mailto:artem@sokolovsky.eu) или в [Issues](https://github.com/iesokolovskyartem/yii_openbank_partners/issues/new).

**Обратите внимание на второй пакет [iesokolovskyartem/openbank_partners](https://github.com/iesokolovskyartem/openbank_partners) у которого [yiisoft/yii2-httpclient](https://github.com/yiisoft/yii2-httpclient) заменён на [guzzle/guzzle](https://github.com/guzzle/guzzle). Данный пакет не будет обновляться после выхода версии 2.0.0. Рекомендуймый пакет для использования: [iesokolovskyartem/openbank_partners](https://github.com/iesokolovskyartem/openbank_partners).**

### Установка
Установить можете с помощью composer

```
composer require iesokolovskyartem/yii_openbank_partners
```

либо указать в composer.json

```
"iesokolovskyartem/yii_openbank_partners": "^1.0"
```

### Зависимости:
PHP >= 7.0

[yiisoft/yii2-httpclient](https://github.com/yiisoft/yii2-httpclient) ~2.0.0

### Возможности:
1. Добавление заявки.
2. Получение статуса заявки.
3. Проверка ИНН на дублирование.
4. Получение результата проверки ИНН на дублирование.
5. Получение словарей (список городов и акций).
