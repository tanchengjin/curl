# php Curl

### install 安装
composer
````
composer require tanchengjin/curl
````

### using 使用
````
TanChengjin\Curl\Curl::request($url, $https = false, $post = false, array $data = []);
````
chain 链式方法
````
$curl=new TanChengjin\Curl\Curl();

#get
$curl->setUrl(url)->setHttps()->get();
or
$curl->get(url,$https=true);

#post
$curl->setUrl(url)->setHttps()->post();
or
$curl->post(url,true,[postData]);
````