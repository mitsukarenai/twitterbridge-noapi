twitterbridge-noapi
===================

Yet another Twitter "bridge" to enjoy timelines and searches without API key

License
===================

Public Domain. Screw you, Twitter.

Requirements
===================

- PHP 5.4 (normally 5.3 too, but untested)
- [PHP Simple HTML DOM Parser](http://simplehtmldom.sourceforge.net/) named "simple_html_dom.php"

Usage
===================

2 operating modes: timeline "u" and search "q". Request is urlencoded. Output either JSON, ATOM feed or plaintext.

##Examples:##

 - @Mitsukarenai's timeline, in plaintext:```http://my.website.com/folder/?u=text_mitsukarenai```
 - (same): ``` http://my.website.com/folder/?u=zkfa_mitsukarenai```
 - @Mitsukarenai's timeline, in JSON:```http://my.website.com/folder/?u=json_mitsukarenai```
 - @Mitsukarenai's timeline, in ATOM:```http://my.website.com/folder/?u=atom_mitsukarenai```
 - search keyword "pizza", in ATOM:```http://my.website.com/folder/?q=atom_pizza```
 - search hashtag "#PRISM", in JSON:```http://my.website.com/folder/?q=json_%23PRISM```
 - search words "Hello" & "World" in plaintext:```http://my.website.com/folder/?q=text_hello+world```
 - search string "Hello World", in plaintext:```http://my.website.com/folder/?q=text_%22hello+world%22```

Summary: the first 4 characters of the request tell the output format (json or atom, else plaintext). The fifth character is a separator (like "_", can be anything), the following characters are either the username (?u=) or the search keyword(s)  (?q=).

Output examples
===================

plaintext:
```
Array
(
    [0] => Array
        (
            [username] => ThatReno
            [fullname] => Reno
            [avatar] => https://si0.twimg.com/profile_images/378800000207837728/2fc0490aeab510e178ebfb5b96a4b7ec_normal.jpeg
            [id] => 361830454967533569
            [link] => https://twitter.com/ThatReno/status/361830454967533569
            [timestamp] => 1375102077
            [text] => &quot;<a href="https://twitter.com/SoSweetGames" class="twitter-atreply pretty-link" dir="ltr" >@SoSweetGames</a>: Who would deny a lapdance, for a fucking pizza?!&quot; Me.
        )

    [1] => Array
        (
            [username] => claufof
            [fullname] => lau
            [avatar] => https://si0.twimg.com/profile_images/378800000172704029/f43bf7f78aa2073a3ee4d8f6e997d6d4_normal.jpeg
            [id] => 361830454803968001
            [link] => https://twitter.com/claufof/status/361830454803968001
            [timestamp] => 1375102077
            [text] => a fazer uma pizza ai que cheirinho i cant im starving nho
        )
)
```

json:
```json
[
    {
        "username": "neniyalo",
        "fullname": "Neni",
        "avatar": "https://si0.twimg.com/profile_images/3719249908/e3688a9e74b422dc064ea884cff70edb_normal.jpeg",
        "id": "361830945579474945",
        "link": "https://twitter.com/neniyalo/status/361830945579474945",
        "timestamp": "1375102194",
        "text": "<a href=\"https://twitter.com/ZulaikhAlIshaqi\" class=\"twitter-atreply pretty-link\" dir=\"ltr\" >@ZulaikhAlIshaqi</a> boleehhh jaa tunggu u p PLKN 3 BULAN PANAS TERIK HITAM TERBAKAR NO MCD KFC PIZZA etc. etc. etc. :p huhuhu"
    }
]
```

atom:
```xml
<entry><author><name>AC534</name><uri>https://twitter.com/AC534</uri></author>
<title type="html"><![CDATA[https://twitter.com/AC534/status/361831242523619331]]></title>
<link rel="alternate" type="text/html" href="https://twitter.com/AC534/status/361831242523619331" />
<id>https://twitter.com/AC534/status/361831242523619331</id>
<updated>2013-07-29T12:51:05+00:00</updated>
<content type="html"><![CDATA[<a href="https://twitter.com/AC534"><img align="top" alt="avatar" src="https://si0.twimg.com/profile_images/378800000147153568/ed37d8284810511cf38192e39fab2d23_normal.jpeg" />AC534</a> Christine ★<br/><blockquote><a href="https://twitter.com/pielsi" class="twitter-atreply pretty-link" dir="ltr" >@pielsi</a> <a href="https://twitter.com/BPatchitcha" class="twitter-atreply pretty-link" dir="ltr" >@BPatchitcha</a> pizza pls  everyday  kami ni pat eh </blockquote>]]></content>
</entry>
```

## ENJOY !
