<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EditableRecipientsDropdownField
 *
 * @author jrast
 */
class EditableRecipientsDropdownField extends EditableFormField {
    static $singular_name = 'Recipientes Dropdown Field';
    static $plural_name = 'Recipientes Dropdown Fields';

    function getFormField() {
        if($receipents = DataObject::get('UserDefinedForm_EmailRecipient')) {
            $receipents = $receipents->toDropdownMap('ID', 'EmailAddress');
            return new DropdownField($this->Name, $this->Title, $receipents, '', null, 'Empfänger auswählen');
        }
        return false;
    }

    function getRecipientFromData($data) {
        if(isset($data[$this->Name])) {
            $value = Convert::raw2sql($data[$this->Name]);
            if($value > 0) {
                $recipient = DataObject::get_one('UserDefinedForm_EmailRecipient', "UserDefinedForm_EmailRecipient.ID = {$value}");
                return ($recipient) ? $recipient : "";
            }
        }
        return false;
    }

    function getValueFromData($data) {
        if($recipient = $this->getRecipientFromData($data)) {
            return $recipient->EmailAddress;
        }
    }
    
    

    function getIcon() {
            return '/userforms/images/editabledropdown.png';
    }

}
?>
