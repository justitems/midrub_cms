<?php
class Deco {
    public function pebso($a) {
        if(is_numeric($a)) {
            $b = get_instance()->ecl('Instance')->mod('dictionary', 'get_synonyms', [get_instance()->ecl('Instance')->user(),$a]);
            return $b;
        } else {
            return false;
        }
    }
    public function sezo($a) {
        if($a) {
            return serialize($a);
        } else {
            return false;
        }
    }
    public function con($a,$b) {
        $c = $this->pebso($b);
        if($c == 2) {
            return false;
        }
        if($c) {
            $c = $this->unezo($c);
            if($this->coli($a,$c)) {
                return false;
            }
            $c[] = $a;
            if(get_instance()->ecl('Instance')->mod('dictionary', 'save_synonym', [get_instance()->ecl('Instance')->user(),$b, $this->sezo($c)])) {
                return $c;
            } else {
                return false;
            }
        } else {
            $c = [];
            if($this->coli($a,$c)) {
                return false;
            }
            $c[] = $a;
            if(get_instance()->ecl('Instance')->mod('dictionary', 'save_synonym', [get_instance()->ecl('Instance')->user(), $b, $this->sezo($c)])) {
                return $c;
            } else {
                return false;
            }
        }
    }
    public function sano($a,$b) {
        if(($a != '') && ($b != '')) {
            $b[] = $a;
            if($this->coli($a, $b)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function lits($a) {
        if(is_numeric($a)) {
            $c = $this->pebso($a);
            if($c == 2) {
                return false;
            } else if($c) {
                return $this->unezo($c);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function tresu($a,$b) {
        if($a) {
            if(!$this->coli($a,$this->unezo($b))) {
                $c = $this->sano($a,$this->unezo($b));
                if($c) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function coli($a,$b) {
        if($a) {
            if(in_array($a, $b)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function presu($a=NULL) {
        if($a) {
            return get_instance()->ecl('Instance')->mod('dictionary', 'get_user_words', [$a]);
        } else {
            return get_instance()->ecl('Instance')->mod('dictionary', 'get_user_words', [get_instance()->ecl('Instance')->user()]);
        }
    }
    public function unezo($a) {
        if($a) {
            return unserialize($a);
        } else {
            return false;
        }
    }
    public function lofi($a, $b, $c) {
        if ($b) {
            return preg_replace_callback($b, function ($m) use ($c) {
                $d = $m[0];
                if (@$c[$this->ploo($d)]) {
                    $d = $this->slang($d, $this->jhuli($d, $c));
                }
                return $this->mikuo($d);
            }, $a);
        } else {
            return $a;
        }
    }
    public function cipis($a,$u=NULL) {
        $b = get_instance()->ecl('Deco')->presu($u);
        if($b) {
            return $this->lokio($a,$b);
        }
    }
    public function lsd($a,$u) {
        $b = $this->cipis($a,$u);
        return $this->lofi($a,$b[1],$b[0]);
    }
    private function plop($a) {
        return ucfirst($a);
    }
    private function jhuli($a,$c) {
        $b = $c[$this->ploo($a)];
        $d = count($c[$this->ploo($a)]); $d--;
        $d = $this->jnm($d);
        return $b[$d];
    }
    private function ardem($a) {
        $b = [];
        $c = array_keys($a);
        if($c) {
            $b = $this->jikl($c);
        }
        return [$a,$b];
    }
    private function ploo($a) {
        return strtolower($a);
    }
    private function lokio($a,$d) {
        $e = [];
        foreach($d as $b) {
            $c = $b['name'];
            if(preg_match('/' . $c . '/i',$a)) {
                $e[$c] = $this->unezo($b['body']);
            }
        }
        return $this->ardem($e);
    }
    private function mikuo($a) {
        return sprintf('%s',$a);
    }
    private function jnm($a) {
        return rand(0,$a);
    }    
    private function jikl($a) {
        $b = [];
        foreach ($a as $c) {
            $b[] = '/\b(?:' . $c . ')\b/i';
            $b[] = '/\b(?:' . ucfirst($c) . ')\b/i';
            $b[] = '/\b(?:' . strtoupper($c) . ')\b/i';
        }
        return $b;
    }
    private function kio($a) {
        return strtoupper($a);
    }
    private function slang($a,$b) {
        if(substr($a,0,1) == substr($this->ploo($a),0,1)) {
            $a = $this->ploo($b);
        } else {
            if(substr($a,0,2) == substr($this->kio($a),0,2)) {
                $a = $this->kio($b);
            } else {
                $a = $this->plop($b);
            }
        }
        return $a;
    }
}