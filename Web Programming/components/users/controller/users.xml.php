<?php
$doc = new DOMDocument();
$doc->loadXML('
<fields>
    <field id="id" name="User Id" type="text"></field>
    <field id="username" name="Username" type="text"></field>
    <field id="password" name="Password" type="password"></field>
    <field id="email" name="E-Mail" type="text"></field>
    <field id="fname" name="First Name" type="text">First Name</field>
    <field id="lname" name="Last Name" type="text">Last Name</field>
    <field id="tel" name="Telephone" type="text">Telephone</field>
    <field id="address" name="Address" type="text">Adress</field>
    <field id="token" name="Token" type="text">Token</field>
    <field id="blocked" name="Is Blocked" type="text"></field>
    <field id="usergroup" name="User Group" type="text">User Group</field>
</fields>');
echo $doc->saveXML();
?>