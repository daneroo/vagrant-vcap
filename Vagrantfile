Vagrant::Config.run do |config|
  config.vm.box = "lucid32"
  config.vm.customize do |vm|
    vm.memory_size = 1024
  end  
  config.vm.forward_port "http", 80, 8080
end
