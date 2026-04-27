# Személyes Pénzügyi Tervező

## Adatbázis felépítése

- #### Adatbázis neve: koltsegvetes

- ### adatok - Felhasználói adatok tábla
|    név    |              leírás                    |    típus     |
| --------- | -------------------------------------- | ------------ |
| id        | A felhasználó egyedi azonosítója       | int          |
| egyenleg  | A felhasználó egyenlege                | bigint       |
| nev       | A felhasználó neve                     | varchar(70)  |
| jelszo    | A felhasználó jelszava (titkosítva)    | varchar(255) |
| keret     | A felhasználó havi kiadásának a kerete | int          |

- ### bevetelek - Bevételek tábla
|   név   |         leírás       |   típus  |
| ------- | -------------------- | -------- |
| id      | Egyedi azonosító     | int      |
| osszeg  | A bevétel összege    | bigint   |
| idopont | A bevétel időpontja  | datetime |

- ### kiadasok - Kiadások tábla
|   név   |        leírás       |   típus  |
| ------- | ------------------- | -------- |
| id      | Egyedi azonosító    | int      |
| osszeg  | A kiadás összege    |  bigint  |
| idopont | A kiadás időpontja  | datetime |