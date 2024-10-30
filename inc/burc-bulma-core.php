<?php

if (!class_exists('BurcBulmaCore')) {
    class BurcBulmaCore
    {
        public $plugin_path = '';
        public $plugin_url = '';
        public $api_endpoints = array(
            array("name" => "Koç", "slug" => "Koç"),
            array("name" => "Boğa", "slug" => "Boğa"),
            array("name" => "İkizler", "slug" => "İkizler"),
            array("name" => "Yengeç", "slug" => "Yengeç"),
            array("name" => "Aslan", "slug" => "Aslan"),
            array("name" => "Başak", "slug" => "Başak"),
            array("name" => "Terazi", "slug" => "Terazi"),
            array("name" => "Akrep", "slug" => "Akrep"),
            array("name" => "Yay", "slug" => "Yay"),
            array("name" => "Oğlak", "slug" => "Oğlak"),
            array("name" => "Kova", "slug" => "Kova"),
            array("name" => "Balık", "slug" => "Balık"),
        );
        function __construct($_plugin_path, $_plugin_url)
        {
            $this->plugin_path = $_plugin_path;
            $this->plugin_url = $_plugin_url;
        }
        public function load()
        {
            add_action('init', function () {
                foreach (glob($this->plugin_path . "/inc/*.php") as $filename) {
                    include($filename);
                }
            });
            add_action('widgets_init', function () {
                foreach (glob($this->plugin_path . "/lib/*.php") as $filename) {
                    include($filename);
                }
                foreach (glob($this->plugin_path . "/widgets/*.php") as $filename) {
                    include($filename);
                    register_widget(str_replace(".php", "", str_replace($this->plugin_path . "/widgets/", "", $filename)));
                }
            });
            add_action('init', function () {
                if ($_GET) {
                    if (isset($_GET["load_burc"])) {
                        $this->load_data();
                        die("");
                    }
                }
            });
            add_action('init', function () {
                $burcBulmaFields = array(
                    array(
                        'title' => 'Give credits to author',
                        'name' => 'give_credits',
                        'type' => 'select',
                        'default_value' => '',
                        'options' => array(
                            array("key" => "", "text" => "Yes"),
                            array("key" => "-1", "text" => "No"),
                        )
                    ),
                    array(
                        'title' => 'Short Code',
                        'name' => 'short_code',
                        'type' => 'input',
                        'default_value' => 'gunluk_burc',
                    ),
                );
                $burcBulmaSettingsCl = new burcBulmaSettingsModule(
                    true,
                    "Medyum Burak Burç Bulma",
                    "medyum_burak_burc_bulma",
                    "administrator",
                    "medyum_burak_burc_bulma_settings",
                    $burcBulmaFields
                );
                $GLOBALS["burcBulmaSettings"] = $burcBulmaSettings;
                global $burcBulmaSettings;
                $burcBulmaSettings = $burcBulmaSettingsCl->load();
                add_shortcode($burcBulmaSettings["short_code"], array($this, 'render_shortcode'));
            });
        }
        public function copyright()
        {
            echo '<div class="burc_copyright">' .
                '<a href="https://www.medyumburak.com/" title="Medyum Burak Burç Bulma">Medyum Burak Burç Bulma</a>' .
                '</div>';
        }
        public function render_shortcode()
        {
            global $burcBulmaSettings;
            ob_start();
            $this->render($burcBulmaSettings);
            $output = ob_get_clean();
            return $output;
        }
        public function render($options)
        {
            $data = $this->get_data();
            echo '<div class="burc_container">' . "\n";
            echo '<div class="form-controls">' . "\n";
            echo '<label>Burcunuz</label>' . "\n";
            echo '<select name="selected_burc" class="form-control">';
            foreach ($data as $item) {
                echo '<option value="' . $item["slug"] . '">' . $item["name"] . '</option>';
            }
            echo '</select>';
            echo '<label>Doğum Saatiniz</label>' . "\n";
            echo '<select name="selected_zaman" class="form-control">';
            ?>
            <option selected="">05-07</option>
            <option>07-09</option>
            <option>09-11</option>
            <option>11-13</option>
            <option>13-15</option>
            <option>15-17</option>
            <option>17-19</option>
            <option>19-21</option>
            <option>21-23</option>
            <option>23-01</option>
            <option>01-03</option>
            <option>03-05</option>
            <?php
            echo '</select>';
            echo '<label>Yükselen Burcunuz</label>' . "\n";
            echo '<input type="text" readonly name="selected_result" class="form-control value="" placeholder="Lütfen hesaplayın.." />';
            echo '<button type="submit" class="form-control">Hesapla</button>';
            if ($options["give_credits"] != "-1") {
                $this->copyright();
            }
            echo "</div>\n";
            echo "</div>\n";
        }
        public function find_value($arr, $col, $val)
        {
            foreach ($arr as $r) {
                if ($r[$col] == $val) {
                    return $r;
                }
            }
            return false;
        }
        public function get_points()
        {
            $filtered_points = array();
            foreach ($this->api_endpoints as $point) {
                $point["icon"] = $this->plugin_url . "assets/img/" . $point["slug"] . ".svg";
                $filtered_points[] = $point;
            }
            return $filtered_points;
        }
        public function get_data()
        {
            if (false === ($ready_data = get_transient('burc_bul_data')) || 1 == 1) {
                $ready_data = array();
                foreach ($this->api_endpoints as $endpoint) {
                    $ready_data[] = array(
                        "name" => $endpoint["name"],
                        "slug" => $endpoint["slug"],
                    );
                }
                set_transient('burc_bul_data', $ready_data, 12 * HOUR_IN_SECONDS);
            }
            return $ready_data;
        }
        public function get_non_tr_str($str)
        {
            $before = array('ğ', 'ü', 'ş', 'ö', 'ç', "ı", "İ");
            $after   = array('g', 'u', 's', 'o', 'c', "i", "i");
            $clean = str_replace($before, $after, $str);
            return $clean;
        }
        public function initAssets()
        {
            add_action('wp_enqueue_scripts', function () {
                wp_register_style('medyum_burak_burc_bulma_style', $this->plugin_url . 'assets/css/medyum-burak-burc-bulma.css');
                wp_enqueue_style('medyum_burak_burc_bulma_style');
            });
            add_action('wp_enqueue_scripts', function () {
                wp_register_script('medyum_burak_burc_bulma_script', $this->plugin_url . 'assets/js/medyum-burak-burc-bulma.js');
                wp_enqueue_script('medyum_burak_burc_bulma_script');
            }, PHP_INT_MAX, 2);
        }
    }
}