# Các kiểu quan hệ giữa các bảng trong Laravel phần 1
Chào các bạn, chắc hẳn trong chúng ta, ai đã từng học lập trình đều biết về 1 số quan hệ giữa các bảng trong database. Vậy thì những kiểu quan hệ này được sử dụng trong Laravel như thế nào,chúng ta sẽ cùng tìm hiểu qua bài viết này.

# Cài đặt môi trường Laravel
Để có cái nhìn trực quan thì mình cần cài đặt dự án Laravel trên môi trường local. Link tham khảo: https://laravel.com/docs/8.x/installation

# Kiểu quan hệ Một - Một (One To One)
Đây là kiểu quan hệ cơ bản trong database. Ví dụ: 1 người dùng chỉ có 1 số điện thoại duy nhất. Để định nghĩa kiểu quan hệ này, chúng ta khai báo 1 hàm `phone` trong Model `User`
```php
// app/Models/User.php
<?php

namespace App\Models;

use App\Models\Phone;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function phone() {
        return $this->hasOne(Phone::class);
    }
}
```

Sau khi khai báo xong chúng ta có thể lấy ra số điện thoại của 1 người dùng nào đó bằng cách
```php
User::find(1)->phone;
```

Để có thể nhìn trực quan dữ liệu, chúng ta có thể tạo 1 `UserController` có phương thức `getPhoneOfUser` để lấy ra số điện thoại của 1 người dùng bất kỳ
```php
// app/Http/Controllers/UserController.php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getPhoneOfUser($id, Request $request) {
        $phone = User::find($id)->phone;
        return $phone;
    }
}
```

Tiếp theo, ta định nghĩa 1 route để có thể truy cập thông qua trình duyệt
```php
// routes/web.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/{id}/phone', [UserController::class, 'getPhoneOfUser']);
```

Tiếp theo ta truy cập vào đường dẫn `{domain}/users/1/phone` để nhìn thấy thông tin số điện thoại của người dùng đó
![image](./images_tutorial/get-phone-of-user.png)

Xem xét phương thức `phone` bên trong file `app/Models/User.php`
```php
// app/Models/User.php
<?php

namespace App\Models;

use App\Models\Phone;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function phone() {
        return $this->hasOne(Phone::class, 'user_id', 'id');
    }
}
```

Eloquent sẽ tự động lấy `foreign_key` thông qua tên lớp. Trong trường hợp này `Phone` model có `foreign_key` là `user_id`. Nếu trong database bảng `phones` của chúng ta có khóa ngoại liên kết đến bảng users không phải là `user_id` mà là một trường khác ví dụ `user_fk_id` thì chúng ta sẽ ghi đè khóa ngoại đó vào đối số thứ 2 của hàm `phone`
```php
// app/Models/User.php
<?php

namespace App\Models;

use App\Models\Phone;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function phone() {
        return $this->hasOne(Phone::class, 'user_fk_id');
    }
}
```

Ngoài ra trường hợp bảng `users` có khóa chính không phải là `id` mà là một trường khác, ví dụ `pk_id` thì chúng ta sẽ ghi đè khóa chính đó vào đối số thứ 3 của hàm `phone`
```php
// app/Models/User.php
<?php

namespace App\Models;

use App\Models\Phone;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function phone() {
        return $this->hasOne(Phone::class, 'user_fk_id', `pk_id`);
    }
}
```

## Xác định nghịch đảo của mối quan hệ
Ở phần trên chúng ta đang truy xuất dữ liệu Model `Phone` thông qua Model `User`. Còn phần này chúng ta sẽ truy xuất dữ liệu Model `User` thông qua Model `Phone`
```php
<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
```

Sau khi khai báo xong chúng ta có thể lấy ra thông tin của người dùng đó thông qua số điện thoại
```php
Phone::find(1)->user;
```

Để có thể nhìn trực quan dữ liệu, chúng ta có thể tạo 1 `PhoneController` có phương thức `getUserByPhone` để lấy ra thông tin của người dùng đó thông qua số điện thoại
```php
```
