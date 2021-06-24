# Các kiểu quan hệ giữa các bảng trong Laravel phần 2
Chào các bạn, bài này là phần 2 trong series 3 phần về các kiểu quan hệ trong Laravel. Trong bài này chúng ta sẽ đề cập đến kiểu quan hệ `Một - Nhiều`, `Nhiều - Nhiều`.

# Kiểu quan hệ Một - Nhiều (One To Many)
Kiểu quan hệ `Một - Nhiều` được sử dụng để định nghĩa 1 model cha có 1 hoặc nhiều model con. Ví dụ 1 người dùng (`user`) có nhiều bài viết (`post`). Để biểu thị mối quan hệ này chúng ta làm như sau: 

Trong `Models User` chúng ta tạo 1 hàm `posts` và bên trong hàm này chúng ta sử dụng hàm hasMany của laravel để biểu thị việc 1 user có nhiều bài post
```php
// app/Models/User.php
<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    ...
    public function posts() {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }
}
```

Sau khi khai báo xong, chúng ta có thể lấy tất cả các bài viết của user bằng cách
```php
use App\Models\User;

User::find(1)->posts;
```

Để có thể nhìn trực quan dữ liệu, chúng ta có thể tạo 1 `UserController` có phương thức `getPostsOfUser` để lấy ra tất cả các bài viết của user
```php
// app/Http/Controllers/UserController.php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    ...
    public function getPostsOfUser($id, Request $request) {
        $posts = User::find($id)->posts;
        return $posts;
    }
}
```

Tiếp theo, ta định nghĩa 1 route để có thể truy cập thông qua trình duyệt
```php
// routes/web.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/users/{id}/posts', [UserController::class, 'getPostsOfUser']);
```

Tiếp theo ta truy cập vào đường dẫn `{domain}/users/1/posts` để nhìn thấy tất cả các bài viết của user đó
![image](./images_tutorial/get-phone-of-user.png)

Xem xét phương thức `posts` bên trong file `app/Models/User.php`
```php
// app/Models/User.php
<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    ...
    public function posts() {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }
}
```

Eloquent sẽ tự động xác định cột `foreign_key` cho `Model Post`. Theo quy ước, Eloquent sẽ lấy tên theo `snake case` của parent model và nối với `_id`. Trong trường hợp trên, Eloquent sẽ có cột `foreign_key` trên `Model Post` là `user_id`.

Giống như phương thức `hasOne`, bạn cũng có thể ghi đè các `foreign_key` và `local_key` bằng cách chuyển các đối số bổ sung cho phương thức `hasMany`:
```php
return $this->hasMany(Post::class, 'foreign_key');
return $this->hasMany(Post::class, 'foreign_key', 'local_key');
```

## Xác định nghịch đảo của mối quan hệ
Ở phần trên chúng ta đang truy xuất dữ liệu `Model Post` thông qua `Model User`. Còn phần này chúng ta sẽ truy xuất dữ liệu `Model User` thông qua `Model Post`. Để xác định nghịch đảo của mối quan hệ `hasMany`, chúng ta dùng một phương thức quan hệ trên model con là `belongsTo`.
```php
// app/Models/Post.php
<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    ...
    public function user() {
        return $this->belongsTo(User::class, 'author_id');
    }
}
```

Sau khi khai báo xong, chúng ta có thể lấy thông tin của user thông qua bài viết bằng cách
```php
use App\Models\Post;

Post::find(1)->user;
```

Để có thể nhìn trực quan dữ liệu, chúng ta có thể tạo 1 `PostController` có phương thức `getUserByPost` để lấy ra thông tin của user thông qua bài viết
```php
// app/Http/Controllers/PostController.php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    ...
    public function getUserByPost($id, Request $request) {
        $user = Post::find($id)->user;
        return $user;
    }
}

```

Tiếp theo, ta định nghĩa 1 route để có thể truy cập thông qua trình duyệt
```php
// routes/web.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/posts/{id}/user', [PostController::class, 'getUserByPost']);
```

Tiếp theo ta truy cập vào đường dẫn `{domain}/users/1/posts` để nhìn thấy tất cả các bài viết của user đó
![image](./images_tutorial/get-phone-of-user.png)

Xem xét phương thức `user` bên trong file `app/Models/Post.php`
```php
// app/Models/Post.php
<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    ...
    public function user() {
        return $this->belongsTo(User::class, 'author_id');
    }
}
```
Eloquent xác định tên `foreign key` bằng cách kiểm tra tên của phương thức quan hệ và nối với dấu "_" và theo sau đó là tên khoá chính. Vì vậy, trong ví dụ này, `foreign key` của `Model User` sẽ là `user_id`.

Tuy nhiên, nếu khóa ngoại cho mối quan hệ của bạn không tuân theo các quy ước này, bạn có thể chuyển tên khóa ngoại tùy chỉnh làm đối số thứ hai cho phương thức `belongsTo`:
```php
public function user() {
    return $this->belongsTo(User::class, 'foreign_key');
}
```

Nếu `parent model` không sử dụng `id` là `primary key`, hoặc bạn muốn sử dụng 1 cột khác, bạn có thể tuỳ chỉnh tham số thứ ba cho phương thức `belongsTo`.
```php
public function user() {
    return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
}
```

# Kiểu quan hệ Nhiều - Nhiều (Many To Many)
Để định nghĩa quan hệ nhiều-nhiều chúng ta cần 1 bảng trung gian ở giữa 2 bảng chính để làm cầu nối. Biến mối quan hệ nhiều-nhiều của 2 bảng chính thành mối quan hệ một-nhiều thông qua bảng con.

Ví dụ: Chúng ta có 2 bảng `Category` và `Product`. Một `category` chứa nhiều `product` và một `product` có thể thuộc nhiều `category`, vì điều này dẫn đến bảng `Category` và bảng `Product` có quan hệ nhiều-nhiều với nhau. Để định nghĩa mối quan hệ này chúng ta cần tạo 1 bảng trung gian là bảng `category_product`

To define this relationship, three database tables are needed: users, roles, and role_user. The role_user table is derived from the alphabetical order of the related model names and contains user_id and role_id columns. This table is used as an intermediate table linking the users and roles.

Để xác định mối quan hệ này, cần có ba bảng cơ sở dữ liệu: người dùng, vai trò và người dùng vai trò. Bảng role_user có nguồn gốc từ thứ tự bảng chữ cái của tên mô hình có liên quan và chứa các cột user_id và role_id. Bảng này được sử dụng như một bảng trung gian liên kết người dùng và vai trò.