Практика 7 Create a product attribute data patch
https://markshust.com/2019/02/19/create-product-attribute-data-patch-magento-2.3-declarative-schema/
+++ Рекомендуется к прочтению https://bsscommerce.com/confluence/magento-2-eav-model-things-you-may-not-know/
Create a product attribute data patch with Magento 2.3's declarative schema
Я проводил рефакторинг одного из моих модулей Magento 2 и заметил, что основные модули Magento 2.3 используют подход декл
аративной схемы, а не скрипты Install/Upgrade. Это новый рекомендуемый подход для Magento версий 2.3 и выше, поскольку в
будущем скрипты обновления будут постепенно сокращены в пользу этого подхода с декларативной схемой.
Я наткнулся на data patches documentation , однако на самом деле это не относится к созданию атрибутов продукта в скриптах
декларативной схемы.
Во-первых, нам нужно создать класс, который реализует DataPatchInterface , и создать экземпляр EavSetupFactory класса в
конструкторе.
Соглашение об именах, которое основные файлы Magento используют для модификации атрибутов в сценариях декларативной
схемы: Verb + (Name or Explanation) + Attribute (s) . Итак, если мы пытаемся добавить один атрибут с именем alternate_color ,
мы называем наш класс AddAlternateColorAttribute .