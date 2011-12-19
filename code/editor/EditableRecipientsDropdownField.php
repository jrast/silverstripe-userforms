<?php
/**
 * EditableRecipientsDropdownField
 *
 * Creates a Dropdownfield with all Recipients for this form.
 * 
 *
 * @package userforms
 * @author jrast
 */

class EditableRecipientsDropdownField extends EditableFormField {
    static $singular_name = 'Recipientes Dropdown Field';
    static $plural_name = 'Recipientes Dropdown Fields';

    /**
     *
     * @return DropdownField containing all Recipients
     */
    function getFormField() {
        if($receipents = DataObject::get('UserDefinedForm_EmailRecipient')) {
            foreach($receipents as $recipient) {
                if($recipient->RecipientName == '') {
                    $recipient->RecipientName = $recipient->EmailAddress;
                }
            }
            $receipents = $receipents->toDropdownMap('ID', 'RecipientName');
            return new DropdownField($this->Name, $this->Title, $receipents, '', null, _t('UserDefinedForm.SELECTRECIPIENTS', 'Wähle einen Empfänger'));
        }
        return false;
    }


    /**
     *
     * @param Array $data Data from the submited Form
     * @return UserDefinedForm_EmailRecipient the selected Recipient in the Form
     */
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

    /**
     * 
     * @param Array $data Data from the submited Form
     * @return String the MailAddress of the Recipient
     */
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
