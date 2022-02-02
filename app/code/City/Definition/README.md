Определение города по IP lvl #2

Задача “Определение города по IP“

Описание
В главном меню создать пункт Локация (значок). При первом вхождении на сайт или при нажатии на пункт меню 
Локация должно появляться всплывающее окно, в котором определяется город посетителя. 
Город посетителя определяется по его IP (использовать сервис IP stack https://ipstack.com/documentation). 
Если город определен не верно, посетитель может нажать на ссылку “Выбрать другой” и в однострочном окне вручную ввести нужный город.
Название города должно появиться в верхнем меню около значка Локации.

Дополнение
В окне “Выберите свой город” заменить ручной ввод выпадающим списком.
Тестирование: определяются город по IP или который определен вручную (выбран из списка)

Усложнение
При определении города может быть ситуация, что будет определен город из ipstack, которого нет в справочнике НП.

Нужно:
В случае если город есть в IP stack, но нет в справочнике НП, следует выбрать областной центр или районный центр,
который есть в справочнике НП. В окне “Выберите свой город” ручной ввод отсутствует, возможен только выпадающий список 
райцентров и областных центров.
Тестирование: определяются только города, которые есть в справочнике НП.
