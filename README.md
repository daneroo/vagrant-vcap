## Cloudfoundry single-vm setup

### References
* [VCAP github repo](https://github.com/cloudfoundry/vcap/)
* [jbarth blog articel](http://jbbarth.com/archives/tags/cloudfoundry)
* [Semmy Purewall's article on vcap user admin](http://blog.semmy.me/post/8608660840/cloud-foundry-user-admin)

## try installation as root - then try it again as vagrant

    apt-get update
    apt-get install openssh-server curl
    bash < <(curl -s -k -B https://raw.github.com/cloudfoundry/vcap/master/setup/install)

    ~/cloudfoundry/vcap/bin/vcap start
    ~/cloudfoundry/vcap/bin/vcap status

    # become an admin
    # edit admins: [derek@gmail.com, foobar@vmware.com]
    emacs ~/cloudfoundry/vcap/cloud_controller/config/cloud_controller.yml 
    ~/cloudfoundry/vcap/bin/vcap restart

    # add php supprt - all that is required is the new vmc client
    sudo gem install vmc --pre

    vmc target http://api.vcap.me:8080
    vmc info
    vmc register --email daniel.lauzon@gmail.com --passwd blablabla

    vmc push im-w
    vmc create-service  mongodb im-w-mongo
    vmc services
    vmc bind-service im-w-mongo im-w
    vmc apps

    # imetrical.phpfogapp.com
    vmc push im-p 
    vmc create-service mysql im-p-mysql im-p

# Usage and examples

## setup
    # to go back: vmc target api.cloudfoundry.com
    vmc target http://api.vcap.me:8080
    vmc info
    vmc register --email daniel.lauzon@gmail.com --passwd blablabla

## node.js example

    cd node-app
    npm install mongodb
    vmc push node-app  #override url : php-app.vcap.me, take away port:8080
    open http://node-app.vcap.me:8080/


## php example

    cd php-app
    vmc push php-app  #override url : php-app.vcap.me, take away port:8080
    open http://php-app.vcap.me:8080/

    ## create - without prompts
    vmc push php-app --path php-app --no-prompt --url php-app.vcap.me --no-start
    vmc create-service mongodb --bind php-app # --name optional
    vmc start php-app
    
    # delete - without prompts - find the service name
    vmc stop php-app
    vmc delete-service

