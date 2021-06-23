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
User::find(1)->posts;
```

Để có thể nhìn trực quan dữ liệu, chúng ta có thể tạo 1 `UserController` có phương thức `getPostsOfUser` để lấy ra số điện thoại của 1 người dùng bất kỳ
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

Tiếp theo ta truy cập vào đường dẫn `{domain}/users/1/posts` để nhìn thấy thông tin số điện thoại của người dùng đó
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
Ở phần trên chúng ta đang truy xuất dữ liệu `Model Post` thông qua `Model User`. Còn phần này chúng ta sẽ truy xuất dữ liệu `Model User` thông qua `Model Post`

Now that we can access all of a post's comments, let's define a relationship to allow a comment to access its parent post. To define the inverse of a hasMany relationship, define a relationship method on the child model which calls the belongsTo method:

Bây giờ chúng ta có thể truy cập tất cả các nhận xét của một bài đăng, hãy xác định mối quan hệ để cho phép một nhận xét truy cập vào bài đăng chính của nó. Để xác định nghịch đảo của một mối quan hệ hasMany, hãy xác định một phương thức quan hệ trên mô hình con gọi phương thức Thuộc về:
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

