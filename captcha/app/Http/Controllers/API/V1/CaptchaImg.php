<?php
    namespace App\Http\Controllers\API\V1;
    use App\Models\Image;

    class CaptchaImg{
        private string $id;
        private string $chosen_class;
        private string $solution;
        public function __construct(array $attributes = [])
        {
            $this->id = $attributes['id'] ?? '';
            $this->chosen_class = $attributes['chosen_class'] ?? '';
            $this->solution = $attributes['solution'] ?? '';
        }

        private function generateSolution(){
            $sol=[];
            $image = new Image();
            for ($i=0; $i<9; $i++){
                $class=$image->getField('class');
                if($class==$chosen_class){
                    $sol[$i]=true;
                } else{
                    $sol[$i]=false;
                }
            }
            $solution=convertString($sol);
            return $solution;
        }

        public function getId(){
            return $this->$id;
        }
    
        public function getSolution(){
            return $this->$solution;
        }
    
        private function getOrderedIds(){
    
        }
        
    }