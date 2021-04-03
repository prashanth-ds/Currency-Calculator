<?php

    include("Lib/simple_html_dom.php");


    class Conversion {

        function __construct()
        {
            $this->countries = array();
            $this->c_countries = array();
            $this->codes = array();
            $this->currency = array();
            $this->currencies = array();
            $this->rate = array();
            $this->base = "USD";
        }

        function economies()
        {
            /*
                  We will scrape the top 10 Economies in the world here.
            */

            $counter = 0;
            $html = file_get_html("https://www.investopedia.com/insights/worlds-top-economies/");
            foreach ($html->find("table.mntl-sc-block-table__table tbody tr") as $val) {
                if ($counter == 0) {
                    $counter++;
                    continue;
                } else {
                    array_push($this->countries, $val->find("td", 0)->plaintext);
                    $counter++;
                }
            }

        }


        function notations()
        {
            /*
                Here we will scrape the ISO Notations of Top 10 Economies that we previously scraped.
            */
            
            $html1 = file_get_html("https://docs.1010data.com/1010dataReferenceManual/DataTypesAndFormats/currencyUnitCodes.html");
            foreach ($html1->find("table#topic_m4v_rt3_5r__table_k2t_fv3_5r tbody tr") as $val) {
                foreach ($this->countries as $val1) {
                    $country = $val->find("td", 0)->plaintext; // used to retrieve country name.
                    if ($country == strtoupper($val1)) {
                        array_push($this->codes, $val->find("td", 2)->plaintext); // used to retrieve iso country code.
                        array_push($this->currency, $val->find("td", 1)->plaintext); // used to retrieve currency.
                        array_push($this->c_countries, $val->find("td", 0)->plaintext);
                    }
                }
            }

            array_pop($this->codes); // used to pop one country's code which has united states in its name.
            array_pop($this->currency); // same as above
            array_pop($this->c_countries);

            $temp = array();
            foreach ($this->c_countries as $c_country) {
                $local = strtolower($c_country);
                array_push($temp, ucwords($local)); // since countries names are all in upperCase so we lower it first and keep it in title format for equality check.
            }

            $this->c_countries = $temp;
            $temp = array();
            $temp2 = array();
            $temp3 = array();
            for($i = 0 ; $i<10 ; $i++){
                for ($j =0 ; $j<10 ; $j++){
                    if($this->countries[$i] == $this->c_countries[$j]) {
                        array_push($temp, $this->c_countries[$j]);
                        array_push($temp2, $this->codes[$j]);
                        array_push($temp3, $this->currency[$j]);
                    }
                }
            }

            $this->c_countries = $temp;
            $this->codes = $temp2;
            $this->currency = $temp3;
            
            return array($temp, $temp2, $temp3);

        }

        function check_symbol($key)
        {
            foreach ($this->codes as $code)
                if (($code == $key) && ($code != $this->base))
                    return 1;
        }

        function retreive($base = 'USD')
        {

            $endpoint = 'latest';
            $this->base = $base;
            $access_key = '14d74c57f14c2e4f03b6f32a'; 
            $ch = curl_init('https://v6.exchangerate-api.com/v6/' . $access_key . "/" . $endpoint . "/" . $this->base);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);

            // Decode JSON response:
            $exchangeRates = json_decode($json, true);

            $i = 0;
            foreach ($exchangeRates['conversion_rates'] as $key => $value) {
                if ($this->check_symbol($key)) {
                    $this->currencies[$i] = $key;
                    $this->rate[$i] = $value;
                    $i = $i + 1;
                }
            }

            // append recieved base currency and rate to the currencies and rate arrays.
            array_push($this->currencies, $this->base);
            array_push($this->rate, 1);

            return array($this->currencies, $this->rate);

        }
    }

?>
