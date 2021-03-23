# Các kiểu quan hệ giữa các bảng trong Laravel phần 1
Chào các bạn, chắc hẳn trong chúng ta, ai đã từng học lập trình đều biết về 1 số quan hệ giữa các bảng trong database. Vậy thì những kiểu quan hệ này được sử dụng trong Laravel như thế nào,chúng ta sẽ cùng tìm hiểu qua bài viết này.

# Kiểu quan hệ Một - Một (One To One)
Đây là kiểu quan hệ cơ bản trong database. Ví dụ: 1 `user` chỉ có 1 `role` duy nhất. Để định nghĩa kiểu quan hệ này, chúng ta khai báo 1 hàm `role` trong Model `User`
```php
// app/Models/User.php
<?php

namespace App\Models;

use App\Models\Role;
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

    public function role() {
        return $this->hasOne(Role::class);
    }
}
```

Sau khi khai báo xong chúng ta có thể lấy ra `Role` của 1 `User` nào đó bằng cách
```php
User::find(1)->role;
```
