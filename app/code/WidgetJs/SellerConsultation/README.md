2. На странице продукта добавить кнопку “Консультация продавца“. При нажатии появляется попап с формой вопроса к продавцу
(можно использовать на странице Contact Us)

Часть 1
-Сделать поле Phone Number обязательным (*), а с поля Email снять этот статус
-Обеспечить валидацию полей формы
https://devdocs.magento.com/guides/v2.4/frontend-dev-guide/validations/form-validation.html
https://inchoo.net/magento-2/validate-custom-form-in-magento-2/
https://amasty.com/knowledge-base/how-to-create-custom-form-validations-in-magento-2.html
https://amasty.com/knowledge-base/how-to-create-custom-form-validations-in-magento-2.html
1)В номере телефона по количеству символов ( в маске должно быть 17 // data-format="+380 dd ddd-dd-dd" //), проверить
правильность мобильного оператора (097, 096,068, 050, 095…), наличие только цифр.
2) В имени указать ограничение до 15 символов
3) В почтовом адресе проверить наличие @ и отсутствие букв кирилицы.
Сообщение можно выдавать текстовой строкой в верху страницы

-Сообщение отсылать на почту администратора.
-Если клиент оставил почту, то на эту почту нужно выслать подтверждение о получении, которое соответствует следующему
шаблону:
Уважаемый (ИМЯ)
Вы задали вопрос:
(продублировать вопрос)
Спасибо за обращение, вы получите ответ в ближайшие три дня.
(Дата отправки письма)
https://store.magenest.com/blog/how-to-send-email-in-magento-2/
https://devdocs.magento.com/guides/v2.4/frontend-dev-guide/templates/template-email.html
https://webkul.com/blog/magento-2-send-transactional-email-programmatically-in-your-custom-module/
https://meetanshi.com/blog/send-custom-emails-programmatically-in-magento-2/