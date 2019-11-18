<?php
    class tarea
    {
        private $nombre="";
        private $fecha="";
        private $terminada ="";
        public function __construct($nombre, $fecha, $terminada)
        {
            $this->nombre = $nombre;
            $this->fecha=$fecha;
            $this->terminada=$terminada;
        }
        public function setNombre ($nombre){
            $this->nombre=$nombre;
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function setFecha($fecha){
            $this->fecha = $fecha;
        }
        public function getFecha(){
            return $this->fecha;
        }
        public function setTerminada($terminada){
            $this->terminada=$terminada;
        }
        public function getTerminada(){
            return $this->terminada;
        }
    }
    class usuario{
        private $cedula="";
        private $tareas = array();
        public function __construct($cedula)
        {
            $this->cedula=$cedula;
        }
        public function setCedula($cedula){
            $this->cedula = $cedula;
        }
        public function getCedula(){
            return $this->cedula;
        }
        public function addTarea($tarea){
            array_push($this->tareas,$tarea);
        }
        public function getTareas(){
            return $this->tareas;
        }
        
    }
?>
