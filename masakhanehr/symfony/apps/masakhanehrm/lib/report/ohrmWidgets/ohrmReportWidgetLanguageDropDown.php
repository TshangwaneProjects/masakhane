<?php

/**
 * MasakhaneHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 MasakhaneHRM Inc., http://www.MasakhaneHRM.com
 *
 * MasakhaneHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * MasakhaneHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class ohrmReportWidgetLanguageDropDown extends sfWidgetForm implements ohrmEnhancedEmbeddableWidget {
    
    private $whereClauseCondition;

    public function configure($options = array(), $attributes = array()) {

        $languageList = $this->_getLanguageList();

        $this->addOption('choices', $languageList);
    }

    public function render($name, $value = null, $attributes = array(), $errors = array()) {
        $value = $value === null ? 'null' : $value;

        $options = array();

        foreach ($this->getOption('choices') as $key => $option) {
            $attributes = array('value' => self::escapeOnce($key));
            
            if ($key == $value) {
                $attributes['selected'] = 'selected';
            }
            
            
            $options[] = $this->renderContentTag(
                            'option',
                            self::escapeOnce($option),
                            $attributes
            );
        }

        $html = $this->renderContentTag(
                        'select',
                        "\n" . implode("\n", $options) . "\n",
                        array_merge(array('name' => $name), $attributes
                ));

        return $html;
    }

    /**
     * Gets all languages.
     * @return string[] $languageList
     */
    private function _getLanguageList() {
        $languageService = new LanguageService();
        $languageList = $languageService->getLanguageList();
        $list = array("" => "-- " . __('Select') . " --");

        foreach($languageList as $language) {
            $list[$language->getId()] = $language->getName();
        }

        return $list;
    }

    /**
     * Embeds this widget into the form. Sets label and validator for this widget.
     * @param sfForm $form
     */
    public function embedWidgetIntoForm(sfForm &$form) {

        

        $widgetSchema = $form->getWidgetSchema();
        $widgetSchema[$this->attributes['id']] = $this;
        $label = ucwords(str_replace("_", " ", $this->attributes['id']));
        $validator = new sfValidatorString();
        
        $required = false;
        
        if (isset($this->attributes['required']) && ($this->attributes['required'] == "true")) {
            $label .= "<span class='required'> * </span>";
            $required = true;            
        }
        
        $requiredMess = __(ValidationMessages::REQUIRED);
        $validator = new sfValidatorString(array('required' => $required), array('required' => $requiredMess));       
        $widgetSchema[$this->attributes['id']]->setLabel($label);
        $form->setValidator($this->attributes['id'], $validator);
    }

    /**
     * Sets whereClauseCondition.
     * @param string $condition
     */
    public function setWhereClauseCondition($condition) {

        $this->whereClauseCondition = $condition;
    }

    /**
     * Gets whereClauseCondition. ( if whereClauseCondition is set returns that, else returns default condition )
     * @return string ( a condition )
     */
    public function getWhereClauseCondition() {

        if (isset($this->whereClauseCondition)) {
            $setCondition = $this->whereClauseCondition;
            return $setCondition;
        } else {
            $defaultCondition = "=";
            return $defaultCondition;
        }
    }

    /**
     * This method generates the where clause part.
     * @param string $fieldName
     * @param string $value
     * @return string
     */
    public function generateWhereClausePart($fieldName, $value) {

        if ($value == '') {
            $whereClausePart = null;
        } else{
            $whereClausePart = $fieldName . " " . $this->getWhereClauseCondition() . " " . $value;
        }

        return $whereClausePart;
    }
    
    public function getDefaultValue(SelectedFilterField $selectedFilterField) {
        return $selectedFilterField->value1;
    }      
}

