Типограф студии Евгения Муравьёва для Tinymce

Инструкция по установке:

1. Скопировать папку jaretypograph в tiny_mce/plugins

2. Подключить плагин при инициализации Tinymce.

Пример:

tinyMCE.init({
...
plugins : "jaretypograph",
...
});

3. Вывести на тулбар редактора кнопку плагина.

Пример:
tinyMCE.init({
...
theme_advanced_buttons1 : "jaretypograph",
...
});