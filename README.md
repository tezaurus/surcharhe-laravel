# Задача

Разработать систему расчета доплаты на проживание в отеле.

Система должна уметь:

- Возвращать общий статус - есть доплата или нет;
- Предоставлять список доплат (Surcharge);
- Предоставлять общую стоимость доплаты.

При расчете стоимости доплаты необходимо учесть, что для каждого типа сертификата (CertificateType) есть свой алгоритм расчета.

```
interface Surcharge {
    label: string; // Название доплаты
    count: number; // Количество единиц текущей доплаты
    price: number; // Стоимость за единицу доплаты
    amount: number; // Общая стоимость доплаты
}
```

## Вводные

### Агрегатор цен

Есть сторонний сервис получения стоимости проживания.

Запрос на получение стоимости:

```
interface PriceRequest {
    adults: int; // Количество взрослых
    children: int[]; // Возраста детей, максимум 5 детей
    dateFrom: string; // Дата заезда <Date<Y-m-d>>
    dateTo: string; // Дата выезда <Date<Y-m-d>>
    hotelIds: number[]; // ID отелей
}
```

```
interface HotelPrice {
    hotelId: number;
    price: number;
}
```

```
interface PriceResponse {
    request: PriceRequest;
    response: HotelPrice[];
}
```

### Сертификат пользователя с условиями

У сертификата есть свойства

```
type CertificateType = 'nominal' | 'thematic';
```

```
interface Certificate {
    adults: int; // Максимальное количество взрослых
    children: int[]; // Возраста детей
    nightsCount: number; // Количество ночей
    price: number; // Стоимость покупки сертификата
    type: CertificateType; // Тип сертификата
}
```

### Отель

У отеля есть свойства

```
interface Hotel {
    id: number; // ID отеля
    adults: int; // Максимальное количество взрослых
    children: int[]; // Возраста детей
}
```

### Контроллер обработки запроса

Контроллер, где обрабатывается запрос пользователя.

Запрос пользователя:

```
interface HotelIndexRequest {
    adults: int; // Количество взрослых
    children: int[]; // Возраста детей, максимум 5 детей
    dateFrom: string; // Дата заезда <Date<Y-m-d>>
    dateTo: string; // Дата выезда <Date<Y-m-d>>
}
```

Необходимо:

1. Создать базовые сущности в системе.
2. Детектировать выход за пределы условия сертификата. Общий на список отелей.
3. Отобрать отели подходящие под запрос пользователя. Если даты не указаны - показывать все отели. Данные по умолчанию: 2 взрослых без детей. Отбираем по доступной вместимости. Т.е. если в запросе 2 взрослых, отель с 3 взрослыми подходит.
4. Просчитать стоимость доплаты для каждого отеля в списке.

## Допущения

Текущие вводные сильно отличаются от реальных. Поэтому оперируем минимальными данными.

По ходу решения задачи условия могут скорректироваться.

Скорее всего за отведенное время решить задачу полностью не получится. Задача - решать задачу, а не дойти до конца.

Важно обращать внимание на нейминг.

Делаем тонкий контроллер. Необходимо внедрить в систему нужные сущности/слои, которые помогали бы реализовать задачу.
