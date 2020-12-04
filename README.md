Nekoringo Api

## Without docker

```
  make init-app
```

## With docker

```
  make docker-restart
```

### Make Role and permission to locale user in production:

```
heroku run php artisan migrate
heroku run php artisan tinker

```

In tinker:

```
$users = \App\Models\User::all();
$userRole = Spatie\Permission\Models\Role::find(1); // Name: viewer
foreach($users as $user) {
  $user->assignRole($userRole);
}
```

### Publican role update:

Update Publican role to nekoringo

```
  use Spatie\Permission\Models\Role;
  $role4 = Role::create(['name' => 'publican']);
```

In tinker:

```
  use Spatie\Permission\Models\Role;
  $viewer = Role::where('name', 'viewer')->first();
  $publican = Role::where('name', 'publican')->first();
  foreach(\App\Models\User::cursor() as $user) {
    if(count($user->pubs) > 0 && $user->hasRole($viewer)){
      $user->removeRole($viewer);
      $user->assignRole($publican);
    }
  }
```
