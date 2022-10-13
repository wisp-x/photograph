<h1 align="center">Photograph</h1>

<p align="center">这是一个简约而又精致的相册集程序，将你精挑细选的作品展示出来，让拍照增添一份仪式感。</p>

### 要求

- PHP 8+
- fileinfo 拓展
- sqlite 3.8+

### 安装

- 下载程序

```shell
git clone https://github.com/wisp-x/photograph.git photograph && cd photograph
```

- 安装拓展

```shell
composer install
```

- 复制环境变量

```shell
cp .env.example .env
```

- 执行安装

```shell
php artisan install
```

> 根据指引安装完成后，需在网站设置中将程序的 `public` 目录设置为运行目录并设置伪静态：
```
location / {  
    try_files $uri $uri/ /index.php$is_args$query_string;  
}
```
> 后台地址为 http(s)://域名/admin。

### 系统配置

> 程序所有可用配置都是通过修改根目录环境变量文件(.env文件)进行设置。

| 配置名                     | 配置值                   | 说明                 |
|-------------------------|-----------------------|--------------------|
| APP_IMAGE_DRIVER        | gd                    | 图片处理驱动(gd/imagick) |
| APP_URL                 | http://127.0.0.1:8000 | 站点域名               |
| APP_PASSWORD            | admin                 | 后台密码               |
| APP_PHOTO_DISK          | public                | 图片使用磁盘             |
| APP_PHOTO_PATH          | photos                | 图片保存路径             |
| APP_PHOTO_QUALITY       | 75                    | 图片保存质量，取值 1-100    |
| APP_THUMBNAIL_DISK      | public                | 缩略图保存磁盘            |
| APP_THUMBNAIL_PATH      | thumbnails            | 缩略图保存路径            |
| APP_THUMBNAIL_QUALITY   | 60                    | 缩略图保存质量，取值 1-100   |
| APP_THUMBNAIL_MAX_SCALE | 1000                  | 缩略图最大尺寸            |

### 磁盘配置

<details><summary>s3(亚马逊 s3)</summary>

| 配置名                   | 配置值 | 说明           |
|-----------------------|-----|--------------|
| AWS_ACCESS_KEY_ID     | -   | AccessKeyId  |
| AWS_SECRET_ACCESS_KEY | -   | AccessKeyKey |
| AWS_DEFAULT_REGION    | -   | 区域           |
| AWS_BUCKET            | -   | 储存桶          |
| AWS_URL               | -   | 域名           |
| AWS_ENDPOINT          | -   | 连接地址         |

</details>

<details><summary>sftp(SFTP)</summary>

| 配置名              | 配置值 | 说明     |
|------------------|-----|--------|
| SFTP_HOST        | -   | 连接地址   |
| SFTP_USERNAME    | -   | 用户名    |
| SFTP_PRIVATE_KEY | -   | SSH 密钥 |
| SFTP_PASSWORD    | -   | 密码     |
| SFTP_PORT        | 22  | 连接端口   |
| SFTP_ROOT        | -   | 根目录    |
| SFTP_URL         | -   | 域名     |

</details>

<details><summary>ftp(FTP)</summary>

| 配置名             | 配置值  | 说明     |
|-----------------|------|--------|
| FTP_HOST        | -    | 连接地址   |
| FTP_USERNAME    | -    | 用户名    |
| FTP_PRIVATE_KEY | -    | SSH 密钥 |
| FTP_PASSWORD    | -    | 密码     |
| FTP_PORT        | 21   | 连接端口   |
| FTP_ROOT        | -    | 根目录    |
| FTP_IS_PASSIVE  | true | 被动模式   |
| FTP_URL         | -    | 域名     |

</details>

<details><summary>oss(阿里云 oss)</summary>

| 配置名                   | 配置值                          | 说明                        |
|-----------------------|------------------------------|---------------------------|
| OSS_ACCESS_KEY_ID     | -                            | App ID                    |
| OSS_ACCESS_KEY_SECRET | -                            | SecretID                  |
| OSS_BUCKET            | test                         | oss 名称                    |
| OSS_ENDPOINT          | oss-cn-shanghai.aliyuncs.com | 区域                        |
| OSS_IS_CNAME          | false                        | true/false 是否以 cname 形式连接 |
| OSS_SECURITY_TOKEN    | -                            | 安全 token                  |

</details>


<details><summary>cos(腾讯云 cos)</summary>

| 配置名             | 配置值          | 说明                |
|-----------------|--------------|-------------------|
| COS_APP_ID      | 1251460152   | App ID            |
| COS_SECRET_ID   | -            | SecretID          |
| COS_SECRET_KEY  | -            | SecretKey         |
| COS_REGION      | ap-guangzhou | 区域                |
| COS_BUCKET      | photograph   | 储存桶名称             |
| COS_DOMAIN      | -            | 域名，不需要 http(s):// |
| COS_PATH_PREFIX | -            | 储存前缀              |

</details>

<details><summary>qiniu(七牛云)</summary>

| 配置名              | 配置值 | 说明        |
|------------------|-----|-----------|
| QINIU_ACCESS_KEY | -   | AccessKey |
| QINIU_SECRET_KEY | -   | SecretKey |
| QINIU_BUCKET     | -   | Bucket    |
| QINIU_DOMAIN     | -   | 域名        |

</details>

### FAQ

- 默认使用本地磁盘，图片储存根文件夹都处于 `storage/app/public`，更改磁盘只需要修改 `APP_PHOTO_DISK`
  即可，例如 `APP_PHOTO_DISK=cos`。
- 建议上传带有 exif 数据的图片，程序会在处理需要的信息后移除该图片的 exif 信息，无需担心泄漏数据。
- 建议图片质量不要超过 75，否则会造成图片过大。
- 使用本地储存，站点迁移到其他服务器后需要删除 `public` 目录下的符号连接(uploads)，然后通过命令 `php artisan storage:link`
  重新生成。

### 许可

- MIT
