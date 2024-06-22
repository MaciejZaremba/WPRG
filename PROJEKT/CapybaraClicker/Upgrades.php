<?php

class Upgrades
{
 public function __construct($upgrade, $cost)
 {
     for($i=0;$i<12;$i++)
     {
        $image = 'url("capy' . $i . '.jpg")';
        $imagelock = 'url("locked.jpg")';
        switch($i)
        {
            case 0: $capy_type = "Classic Capybara"; break;
            case 1: $capy_type = "Mount Capybara"; break;
            case 2: $capy_type = "Rider Capybara"; break;
            case 3: $capy_type = "Relaxed Capybara"; break;
            case 4: $capy_type = "Smart Capybara"; break;
            case 5: $capy_type = "Capijuara"; break;
            case 6: $capy_type = "Office Capybara"; break;
            case 7: $capy_type = "Capybara Plushie"; break;
            case 8: $capy_type = "Proud Capybara"; break;
            case 9: $capy_type = "Tech Support Capybara"; break;
            case 10: $capy_type = "Blessed Capybara"; break;
            case 11: $capy_type = "Wartime Capybara"; break;

        }

        if($upgrade<12 || $i < 11)
        {
            if($i<$upgrade+1)
            {
                $style = "<input type='submit' name='upg' value='' disabled style='background: " . $image . "; background-size: 100% 100%'>";">";
                echo "<label for='$i'>" . $capy_type . "</label>" . $style . "<label for='$i'>Bought!</label>";
            } else if($i==$upgrade+1) {
                $style = "<input type='submit' name='upg' value='' style='background: " . $image . "; background-size: 100% 100%'>";">";
                echo "<label for='$i'>" . $capy_type . "</label>" . $style . "<label for='$i'>$cost C</label>";
            } else {
                $style = "<input type='submit' name='upg' value='' disabled style='background: " . $imagelock . "; background-size: 100% 100%'>";">";
                echo "<label for='$i'>Locked</label>" . $style . "<label for='$i'>??? C</label>";
            }
        } else {
            $style = "<input type='submit' name='upg' value='' style='background: " . $image . "; background-size: 100% 100%'>";">";
            echo "<label for='$i'>" . $capy_type . "</label>" . $style . "<label for='$i'>$cost C</label>";
        }
    }
 }
}