<?php
namespace AgSoftware\SearchDos\Plugins;

class Autocomplete
{

    public function __construct(
        \Magento\Framework\Event\ManagerInterface $eventManager) {
            $this->_eventManager= $eventManager;
    }
    // public function beforeGetCategories(
    //     \AgSoftware\SearchDos\Rewrite\Autocomplete $subject,
    //     $categories) {
    //         $out[0] =[
    //             'name'=> 'mycategories',
    //             'url'=>'bulla'
    //         ];
    //     return $out;
    // }
    public function afterGetCategories(
        \AgSoftware\SearchDos\Rewrite\Autocomplete $subject,
        $categories) {
        $categories[0] = [
            'name' => 'Marvin',
            'url' => 'magento2.test',
        ];
        return $categories;
    }
    public function aroundGetItems(
        \AgSoftware\SearchDos\Rewrite\Autocomplete $subject,
        \Closure $procced
    ) {
        $var = $procced();
        $var["Nota"] = "AroundPlugin";
        //array_push($var, $object);
        //logic
        return $var;
    }
    public function aroundDispachEvent(
        \AgSoftware\SearchDos\Rewrite\Autocomplete $subject,
        \Closure $procced
    ) {
        $this->_eventManager->dispatch(
            'searched',
            ['word' => [$subject->getRequest()->getParam('q')]]
        );
        
    }
}
