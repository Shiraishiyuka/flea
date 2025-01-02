

<div class="search">
    <form action="{{ route('home_route') }}" method="GET">
        <input type="text" name="search" class="search-input" placeholder="なにをお探しですか？" value="{{ $searchQuery ?? '' }}">
    </form>
</div>

<div class="form">
    <form action="/" method="post">
        @csrf
        @if (Auth::check())
            <!-- ログイン済みの場合、ログアウトボタンを表示 -->
            <input class="form_item" type="submit" value="ログアウト" name="logout">
            @else
            <!-- 未ログインの場合、ログインボタンを表示 -->
            <input class="form_item" type="submit" value="ログイン" name="login">
        @endif
            <input class="form_item" type="submit" value="マイページ" name="mypage">
            <input class="form_item" type="submit" value="出品" name="sell">
        
    </form>
</div>
