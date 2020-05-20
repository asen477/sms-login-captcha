laravel-admin login SMS verification code
======

Installation
First, install dependencies:

    composer require Trunks/sms-login-captcha
 
Configuration
 In the extensions section of the config/admin.php file, add some configuration that belongs to this extension.
 
     'extensions' => [
         'sms-login-captcha' => [
             // set to false if you want to disable this extension
             'enable' => true,
         ]
     ]
     
### 注意事项
<div>
    <table border="0">
	  <tr>
	    <th>Version</th>
	    <th>Laravel-Admin Version</th>
	  </tr>
	  <tr>
	    <td>^1.7.1</td>
	    <td>< 1.6.10</td>
	  </tr>
	  <tr>
            <td>^1.8</td>
            <td>1.6.10 <= 1.7</td>
          </tr>
	  <tr>
            <td>^2.0</td>
            <td>>= 1.7</td>
          </tr>
	</table>
</div> 
