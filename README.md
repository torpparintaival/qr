# QR

This repository contains redirections for Torpparintaival natural path
info display QR codes.

## Toimintaperiaate

Rastitauluissa on QR-koodit, jotka ohjaavat kunkin rastin omaan GitHub Pagesilla tehtyyn www-osoitteeseen:

 * [https://torpparintaival.github.io/qr/01a/](https://torpparintaival.github.io/qr/01a/)
 * [https://torpparintaival.github.io/qr/01a/](https://torpparintaival.github.io/qr/01b/)
 * ...
 * [https://torpparintaival.github.io/qr/02/](https://torpparintaival.github.io/qr/02/)
 * ...
 * [https://torpparintaival.github.io/qr/15/](https://torpparintaival.github.io/qr/15/)

Täältä kävijä ohjataan varsinaiseen kohteeseen. Kohteen osoite on sivulla kahdesti:

```
<html>
<head>
<meta http-equiv="refresh" content="0; url=https://youtu.be/gMGWOHtsWao" />
</head>
<body>
<a href="https://youtu.be/gMGWOHtsWao">Jatka...</a>
</body>
</html>
```

Tässä siis ohjataan kävijä edelleen kyseiseen Youtube-osoitteeseen.

QR-koodien lisäksi osoitteessa [https://torpparintaival.github.io/qr/](https://torpparintaival.github.io/qr/) on "etusivu", josta on linkit kaikkiin rastitauluihin. Periaatteessa maastossa liikkuvan kävijän ei koskaan pitäisi nähdä tätä sivua, koska QR-koodit eivät johdata tälle sivulle.

## QR-koodit

Tauluissa olevat QR-koodit on tehty [maksuttomalla verkkopalvelulla](https://www.the-qrcode-generator.com/):
 * URL, Static QR Code: tähän annetaan GitHub Pages -osoite
 * Save as SVG (vektorikuvaa on helpompi venyttää kuin PNG-muotoista)

Kaikkien taulujen QR-koodit ovat hakemistossa `qr-svg`.

## Taulut

 * Skannatut taulut löytyvät `images/original/`
 * Taulut, joihin on yhdistetty QR-koodit ja matologo löytyvät `images/final/`

## Acknowledgements

 * Web page template: [https://templated.co/ion]
 * Map icon: [https://iconstore.co/redirect/?icon-pack=free-camping-icons]
