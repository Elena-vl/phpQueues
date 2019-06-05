<?php


class Passwordlist extends SplQueue
{
    private $mySize = 0;//максимально допустимое количество элементов очереди
    public function __construct($size = 0) {
        if(isset($size)) {
            $this->mySize = $size;
        }
    }

    /**
     * класс, который будет наследовать функционал стандартного, но с ограничением по количеству элементов
     * @param mixed $value
     */
    public function enqueue($value) {

        if($this->mySize && $this->count() == $this->mySize) {
            $this->dequeue();//удаления элементов
        }
        parent::enqueue($value);//переопределяет метод родительского класса и необходим для добавления элементов в очередь
    }

    /**
     * преобразование элементов очереди в простой массив
     * @return array
     */
    public function toArray() {
        $array = [];
        foreach ($this as $item) {
            $array[] = $item;
        }
        return $array;
    }
}