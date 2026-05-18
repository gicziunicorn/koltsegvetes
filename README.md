<div align = center>

# <img src="https://avatars.githubusercontent.com/u/230545579?s=400&u=6530a65160b0443d1bfd6764ea9d9b95803fa133&v=4" width=38 align=top> AlphaCode – Személyes pénzügyi tervező

</div>

### Készítők: Giczi Dániel, Bartucz Gábor Imre

<br>

## A projektről:

>A célünk egy könnyen használható és egyszerű költségvetés tervező oldal.

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
|    név    |          leírás        |   típus  |
| --------- | ---------------------- | -------- |
| id (PK)   | Egyedi azonosító       | int      |
| osszeg    | A bevétel összege      | bigint   |
| idopont   | A bevétel időpontja    | datetime |
| kategoria | A bevétel kategóriája  | varchar(50) |

- ### kiadasok - Kiadások tábla
|    név    |         leírás        |   típus  |
| --------- | --------------------- | -------- |
| id (PK)   | Egyedi azonosító      | int      |
| osszeg    | A bevétel összege     | bigint   |
| idopont   | A bevétel időpontja   | datetime |
| kategoria | A bevétel kategóriája | varchar(50) |
