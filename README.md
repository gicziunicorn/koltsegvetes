# Személyes Pénzügyi Tervező

## Adatbázis felépítése

- #### Adatbázis neve: koltsegvetes

- ### adatok - Felhasználói adatok tábla
|    név    |              leírás                    |    típus     |
| --------- | -------------------------------------- | ------------ |
| nev (PK)  | A felhasználó neve                     | varchar(100) |
| jelszo    | A felhasználó jelszava (titkosítva)    | varchar(255) |
| egyenleg  | A felhasználó egyenlege                | bigint       |
| keret     | A felhasználó havi kiadásának a kerete | bigint       |

- ### bevetelek - Bevételek tábla
|   név   |        leírás        |   típus  |
| ------- | -------------------- | -------- |
| id (PK) | Egyedi azonosító     | int      |
| osszeg  | A bevétel összege    | bigint   |
| idopont | A bevétel időpontja  | datetime |

- ### kiadasok - Kiadások tábla
|   név   |        leírás       |   típus  |
| ------- | ------------------- | -------- |
| id (PK) | Egyedi azonosító    | int      |
| osszeg  | A kiadás összege    | bigint   |
| idopont | A kiadás időpontja  | datetime |