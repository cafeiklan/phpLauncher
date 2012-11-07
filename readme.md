![phpLauncher - Codeigniter with Bootstrap and other good things which is inspired by [CI-Bootstrap][1]](https://github.com/jiji262/phpLauncher/raw/master/logo.jpg)

  [1]: https://github.com/RyanDavis/CI-Bootstrap

# Change Logs

## 2012-11-07
> 更新表单验证插件
> 更新上传插件

## 2012-07-13
> remove some sparks
> change the IDE autocomplete method

## 2012-07-12

> 增加中文字符串截断函数到base helper中

## 2012-06-15

> Added MY_Log library which supports subdirectories and custom catalogs to overwrite CI's LOG.

> Added Theme system to support multiple themes. (sparks/assets was changed to support this)

> Added "bluesky" theme.

> Moved MY_Session to application/library folder.

> Updated Codeigniter to 2.1.1(only replace the system folder)

> Updated Twitter Bootstrap to V2.0.4

> Moved the language files to application folder and change the config language to ZH-CN

> Redirect to the orignal link after login

## 2012-05-31

> Replace the orignal Session library with Hex's version.


## 2012-03-30
> Version 1.0 released - 20120330

# The libraries used:

TankAuth:
https://github.com/ilkon/Tank-Auth
 
Twitter BootStrap:
http://twitter.github.com/bootstrap/

Template:
http://williamsconcepts.com/ci/codeigniter/libraries/template/index.html

MY_Log:
## Usage of MY_Log:
### in config.php:
> $config['mylog_cats']= array('CAT1','CAT2','CAT3');
> $config['mylog_sub_directories']= true;
### when wanting to log:
> log_message("CAT1", "log message here");
Logs will be saved in application/logs/CAT1/log-yy-mm-dd.php

Pagination:
https://github.com/javiervd/Zebra-Pagination-for-Twitter-Bootstrap

HMVC:
https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc/wiki/Home

Autocomplete in IDE:
https://github.com/Stunt/Codeigniter-autocomplete
## Usage:
When adding new class autocomplete, change the application/config/autocomplete.php file.


# The sparks used:

Tracer:
http://getsparks.org/packages/tracer/versions/HEAD/show
## Usage of Tracer Spark
> $this->load->spark( 'tracer/x.x' );
>    // keep on rendering page if false ( default )
>    trace( $_SERVER, FALSE );
>    // exit php and rendering if true
>    trace( $_SERVER, TRUE );
or
> $this->load->view( 'viewname', $data ); 
> // See  http://codeigniter.com/user_guide/libraries/loader.html for more information on views and data.
> trace_viewdata( TRUE ); // will exit if true, no if false

My_Model:
http://getsparks.org/packages/my-model/versions/HEAD/show

table_torch:
http://getsparks.org/packages/table_torch/versions/HEAD/show

Messages:
http://getsparks.org/packages/messages/versions/HEAD/show

Captcha:
http://getsparks.org/packages/Captcha/versions/HEAD/show

mobiledetection:
http://getsparks.org/packages/mobiledetection/versions/HEAD/show
## Usage:
> $this->load->spark('mobiledetection/1.0.1');
> echo "***".$this->mobiledetection->isMobile()."***";

assets:
http://getsparks.org/packages/assets/versions/HEAD/show

curl:
http://getsparks.org/packages/curl/versions/HEAD/show
http://philsturgeon.co.uk/code/codeigniter-curl
https://github.com/philsturgeon/codeigniter-curl

# Good things but not be used:

https://github.com/addyosmani/jquery-ui-bootstrap

http://getsparks.org/packages/Debug-Toolbar/versions/HEAD/show

http://getsparks.org/packages/formgenlib/versions/HEAD/show

http://getsparks.org/packages/debug_helper/versions/HEAD/show

http://getsparks.org/packages/fire_log/versions/HEAD/show

http://getsparks.org/packages/formbuilder/versions/HEAD/show
http://newfinds.com/code-igniter-sparks/auto-spark/

# Known issues

> Soma sparks can't work

> assets has problem with compress js and css(image path issue)

# Todos

> The common files in theme should be placed to one place.
> View the logs with the fire_log way.
> table_torch CSS style change

> User manual