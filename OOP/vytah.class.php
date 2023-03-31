<?php
class Vytah {
    private $patro;
    private $minPatro;
    private $maxPatro;

    public function __construct($minPatro, $maxPatro) {
        $this->minPatro = $minPatro;
        $this->maxPatro = $maxPatro;
        $this->patro = $minPatro;
    }

    public function getPatro() {
        return $this->patro;
    }

    public function nahoru() {
        if ($this->patro < $this->maxPatro) {
            $this->patro++;
            echo "Jsem ve " . $this->patro . ". patře, jedu nahoru do " . ($this->patro + 1) . ". patra";
            return true;
        } else {
            echo "Jsem v " . $this->patro . ". patře, výš už to nejde";
            return false;
        }
    }

    public function dolu() {
        if ($this->patro > $this->minPatro) {
            $this->patro--;
            echo "Jsem ve " . $this->patro . ". patře, jedu dolů do " . ($this->patro - 1) . ". patra";
            return true;
        } else {
            echo "Jsem v " . $this->patro . ". patře, níž už to nejde";
            return false;
        }
    }

    public function azNahoru() {
        while ($this->nahoru()) {}
    }

    public function azDolu() {
        while ($this->dolu()) {}
    }

    public function __toString() {
        return "Výtah z " . $this->minPatro . ". do " . $this->maxPatro . ". patra, aktuálně v " . $this->patro . ". patře";
    }
}
?>
