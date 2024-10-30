<?php
/*
Plugin Name: Medyum Burak Burç Bulma
Plugin URI:  https://wordpress.org/plugins/medyum-burak-burc-bulma/
Version: 1.0
Author: Medyum Burak
Author URI: https://www.medyumburak.com/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Contributors: medyumburak
Tags: burçlar,yükselen burç,burç hesaplama
Description: Medyum Burak Yükselen Burç Hesaplama ile hayatınıza daha iyi yön verebilirsiniz.Otuz yaşından sonra Yükselen burç özelliklerine dönüş yaparsınız. Sizde her 2 saatte bir değişen yükselen burçunuzu bulmak için hesaplama eklentisini kullanabilirsiniz

Medyum Burak Burç Bulma is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Medyum Burak Burç Bulma is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Medyum Burak Burç Bulma If not, see {License URI}.
*/

require(dirname(__FILE__).'/inc/burc-bulma-core.php');
if (class_exists('BurcBulmaCore')) {
    global $brcBulma;
    $brcBulma = new BurcBulmaCore(plugin_dir_path(__FILE__), plugin_dir_url(__FILE__));
    $brcBulma->load();
    $brcBulma->initAssets();
    $GLOBALS["brcBulma"] = $brcBulma;
}