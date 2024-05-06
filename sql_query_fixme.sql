create table if not exists author
(
    id         int unsigned auto_increment
        primary key,
    first_name varchar(50) not null,
    last_name  varchar(50) not null
);

create table if not exists book
(
    id        int unsigned auto_increment
        primary key,
    name      varchar(50)  not null,
    isbn10    char(13)     not null,
    author_id int unsigned not null
);

INSERT IGNORE INTO author (id, first_name, last_name)
VALUES (1675, 'Zaria', 'Barton');

INSERT IGNORE INTO book (id, name, isbn10, author_id)
VALUES (3326, 'Est aperiam.', '8830161489', 1675);
INSERT IGNORE INTO book (id, name, isbn10, author_id)
VALUES (3327, 'Accusantium quia.', '3679509375', 1675);
INSERT IGNORE INTO book (id, name, isbn10, author_id)
VALUES (8649, 'Tempora dolores et.', '0797121986', 1675);
INSERT IGNORE INTO book (id, name, isbn10, author_id)
VALUES (22943, 'Occaecati aut in.', '7482383522', 1675);
INSERT IGNORE INTO book (id, name, isbn10, author_id)
VALUES (24583, 'Quidem facilis odit.', '4758194009', 1675);
INSERT IGNORE INTO book (id, name, isbn10, author_id)
VALUES (25146, 'Voluptates ut.', '2154230628', 1675);
INSERT IGNORE INTO book (id, name, isbn10, author_id)
VALUES (25310, 'Et iusto facere vel.', '9573912252', 1675);
INSERT IGNORE INTO book (id, name, isbn10, author_id)
VALUES (27888, 'Magni et ut.', '1667543172', 1675);

# добавляю нужный индекс к существующей таблице.
# author_id - потому что он используется в соединении таблиц,
# first_name, last_name - потому что по ним ищет книги.
ALTER TABLE author
    ADD INDEX name_index (first_name, last_name);
ALTER TABLE book
    ADD INDEX name_author_id(author_id);

# CREATE INDEX name_author_id ON book (author_id);
# CREATE INDEX name_index ON author (first_name, last_name); или вот так создать новый индекс

# новый запрос через созданный индекс+проверка на єфективность использования индексов
# EXPLAIN
SELECT author.`first_name`, author.`last_name`, COUNT(book.id) AS book_count
FROM author
         LEFT JOIN book ON author.id = book.author_id
WHERE author.first_name = 'Zaria'
  AND author.last_name = 'Barton'
GROUP BY author.`first_name`, author.`last_name`;

# второй вариант без указания названий таблиц перед полями, т.к. поля имя и фамилия в таблице книги не используются
# EXPLAIN
SELECT `first_name`, `last_name`, COUNT(book.id) AS book_count
FROM author
         LEFT JOIN book ON author.id = book.author_id
WHERE `first_name` = 'Zaria'
  AND `last_name` = 'Barton'
GROUP BY `first_name`, `last_name`;