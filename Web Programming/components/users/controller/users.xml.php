<?php
$doc = new DOMDocument();
$doc->loadXML('
<fields>
    <field id="user_id" name="User Id" type="text" span="You cannot define or change the User ID this is done automatically"></field>
    <field id="username" name="Username" type="text" span="You can Edit the Username" error="This username already exists" empty="false"></field>
    <field id="password" name="Password" type="password" empty="false"></field>
    <field id="email" name="E-Mail" type="text" span="Format NAME@DOMAIN.CC" empty="false"></field>
    <field id="fname" name="First Name" type="text" empty="false">First Name</field>
    <field id="lname" name="Last Name" type="text" empty="false">Last Name</field>
    <field id="pname" name="Parent Name" type="text" empty="false">Parent Name</field>
    <field id="cemester" name="Cemester" type="text" empty="true">Cemester</field>
    <field id="telephone" name="Telephone" type="text" empty="true">Telephone</field>
    <field id="address" name="Address" type="text" empty="true">Adress</field>
    <field id="token" name="Token" type="text" empty="true" span="Tokens used by UNIPI Android Application">Token</field>
    <field id="block" name="Is Blocked" type="text" empty="false"></field>
    <field id="type" name="User Group" type="text" empty="true">User Group</field>
</fields>');
echo $doc->saveXML();
?>