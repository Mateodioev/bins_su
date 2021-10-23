Bins.su scrapper in PHP!
================

This is a scrapper that optionally works with webshare proxies

![](https://i.imgur.com/oDENIUL.png)



It is very easy to use!
--------

### Install source from GitHub
To install the source code:

    $ git clone https://github.com/Mateodioev/bins_su.git

And include it in your scripts:
    
```php
    require __DIR__ . '/loader.php';
    
    use Scrapper\Config\ScrapperBin;
    
    $fim = ScrapperBin::Search($bin_to_search);
    $fim['result']['flag'] = getFlag($fim['result']['country']); // To se flag country
```
