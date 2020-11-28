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
