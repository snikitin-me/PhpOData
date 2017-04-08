<?php

class ODataScheme{
    private $entities;
    
    function __construct() {
        $this->entities=[];
    }
    
    public static function parse($json){
        $schemeConfig=json_decode($json,true);
        $scheme=new ODataScheme();
        //TODO: Check scheme
        
        foreach ($schemeConfig["entities"] as $name=>$config){
            $entity=new ODataSchemeEntity($name);
            $scheme->addEntity($entity);
            
            if (isset($config["fields"]))
                foreach ($config["fields"] as $field){
                    $entity->addField(ODataSchemeEntityField::parse($field));
                }
                
                
            if (isset($config["associations"]))
                foreach ($config["associations"] as $associcationField=>$associationData){
                    $entity->addAssociation(ODataSchemeEntityAssociation::parse($associcationField,$associationData));
                }
        }
        
        return $scheme;
    }
    
    public function addEntity(ODataSchemeEntity $entity){
        $this->entities[$entity->getName()]=$entity;
    }
    
    public function getEntity($name){
        return $this->entities[$name];
    }
}