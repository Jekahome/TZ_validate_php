# Task

```

Необходимо доработать класс рассылки Newsletter,
что бы он отправлял письма
и пуш нотификации для юзеров из UserRepository.

За отправку имейла мы считаем вывод в консоль строки: "Email {email} has been sent to user {name}"
За отправку пуш нотификации: "Push notification has been sent to user {name} with device_id {device_id}"

Так же необходимо реализовать функциональность для валидации имейлов/пушей:
1) Нельзя отправлять письма юзерам с невалидными имейлами
2) Нельзя отправлять пуши юзерам с невалидными device_id. Правила валидации можете придумать сами.
3) Ничего не отправляем юзерам у которых нет имен
4) На одно и то же мыло/device_id - можно отправить письмо/пуш только один раз

Для обеспечения возможности масштабирования системы (добавление новых типов отправок и новых валидаторов),
можно добавлять и использовать новые классы и другие языковые конструкции php в любом количестве.
Реализация должна соответствовать принципам ООП

```

### PS.
```
Я уже сталкивался подобного рода задачей про фильтрацию данных.
И я решил взять свою нароботку, немного модифицировав под требования задачи.
Решение в первую очередь для гибкости и расширения фильтров.
Класс Validator регистрирует все фильтры для будущих вариантов использования, дабы  убрать дублирование фильтров.
Но в случае ваших "уникальных" фильтров или правил вы можете реализовать свой класс от интерфейса IValidator.
Плюс к гибкости, это возможность комбинировать правила с помощью сочетания классов FilterAnd/Or/Not.
И возможность использовать свою логику в callback функциях усиливает возможности ваших правил.
Минус в использовании callback функций в том, что они запоминают состояние обьекта и перед новым использованием
необходимо инициализировать валидационные свойства новыми значениями. Этот недостаток обусловлен тем, что первоначально 
такая система валидации предназначена для HTTP запроса и должна отрабатывать только один раз.
```