<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - r/Screenbites</title>
    <style>
        :root {
            --reddit-bg: #030303;
            --reddit-card: #1A1A1B;
            --reddit-border: #343536;
            --reddit-text: #D7DADC;
            --reddit-muted: #818384;
            --reddit-hover: #272729;
            --color-amarillo: #ffd000;
            --upvote-color: #ff4500;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'IBM Plex Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: var(--reddit-bg); color: var(--reddit-text); min-height: 100vh; overflow-y: scroll; }

        /* --- HEADER --- */
        header { position: sticky; top: 0; display: flex; justify-content: space-between; align-items: center; padding: 10px 5%; background-color: var(--reddit-card); z-index: 1000; border-bottom: 1px solid var(--reddit-border); }
        header .logo img { height: 35px; }
        nav ul { list-style: none; display: flex; gap: 30px; align-items: center; }
        nav a { color: var(--reddit-text); text-decoration: none; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: color 0.2s; }
        nav a:hover { color: var(--color-amarillo); }

        .header-avatar { width: 32px; height: 32px; border-radius: 4px; object-fit: cover; }

        /* --- LAYOUT --- */
        .layout-wrapper {
            display: flex;
            justify-content: center;
            gap: 24px;
            max-width: 1000px;
            margin: 24px auto;
            padding: 0 16px;
        }
        .main-feed { flex: 1; min-width: 0; max-width: 640px; }
        .sidebar { width: 312px; display: flex; flex-direction: column; gap: 16px; }

        @media (max-width: 900px) { .sidebar { display: none; } }

        /* --- CREATE POST BOX --- */
        .create-post-box {
            background-color: var(--reddit-card);
            border: 1px solid var(--reddit-border);
            border-radius: 4px;
            padding: 12px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 24px;
        }
        .create-post-avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; }
        .create-post-form { flex: 1; display: flex; flex-direction: column; gap: 12px; }
        
        .create-post-input {
            width: 100%; background: var(--reddit-hover); border: 1px solid var(--reddit-border);
            color: var(--reddit-text); padding: 10px 16px; border-radius: 4px; font-size: 14px;
            outline: none; transition: 0.2s; resize: vertical; min-height: 40px; font-family: inherit;
        }
        .create-post-input:hover, .create-post-input:focus { background: var(--reddit-bg); border-color: var(--reddit-text); }

        .create-post-tools { display: flex; justify-content: space-between; align-items: center; }
        
        .movie-select {
            background: transparent; color: var(--reddit-text); border: 1px solid var(--reddit-border);
            padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; outline: none; cursor: pointer;
        }
        .movie-select option { background: var(--reddit-card); color: var(--reddit-text); }
        .btn-submit { background: var(--reddit-text); color: var(--reddit-card); border: none; padding: 6px 16px; border-radius: 20px; font-weight: bold; cursor: pointer; transition: 0.2s; }
        .btn-submit:hover { background: #fff; }

        /* --- REDDIT POST CARD --- */
        .reddit-card {
            background-color: var(--reddit-card);
            border: 1px solid var(--reddit-border);
            border-radius: 4px;
            display: flex;
            margin-bottom: 16px;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        .reddit-card:hover { border-color: var(--reddit-muted); }

        /* Left Voting Sidebar */
        .vote-sidebar {
            width: 40px;
            background-color: rgba(255,255,255,0.02);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 4px;
            border-radius: 4px 0 0 4px;
            border-right: 1px solid transparent;
        }
        .vote-btn {
            background: transparent; border: none; color: var(--reddit-muted); cursor: pointer;
            padding: 4px; border-radius: 2px; display: flex; align-items: center; justify-content: center;
        }
        .vote-btn svg { width: 24px; height: 24px; }
        .vote-btn:hover { background-color: var(--reddit-hover); }
        .vote-btn.upvote:hover { color: var(--upvote-color); }
        .vote-btn.downvote:hover { color: #7193ff; }
        
        .vote-btn.upvote.active { color: var(--upvote-color); }
        .vote-count { font-size: 12px; font-weight: bold; color: var(--reddit-text); margin: 2px 0; }
        .vote-count.active { color: var(--upvote-color); }

        /* Post Content */
        .post-content { padding: 8px 16px 8px 8px; flex: 1; min-width: 0; }
        
        .post-meta { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--reddit-muted); margin-bottom: 8px; flex-wrap: wrap; }
        .meta-avatar { width: 20px; height: 20px; border-radius: 50%; object-fit: cover; }
        .subreddit { color: var(--reddit-text); font-weight: bold; text-decoration: none; display: flex; align-items: center; gap: 4px; }
        .subreddit svg { width: 14px; height: 14px; color: var(--color-amarillo); }
        .posted-by { display: flex; gap: 4px; }

        .post-body { font-size: 14px; line-height: 1.4; color: var(--reddit-text); margin-bottom: 12px; word-wrap: break-word; }

        /* Action Bar */
        .action-bar { display: flex; gap: 4px; margin-top: 8px; }
        .action-btn-flat {
            background: transparent; border: none; color: var(--reddit-muted); font-size: 12px; font-weight: bold;
            display: flex; align-items: center; gap: 6px; padding: 6px 8px; border-radius: 4px; cursor: pointer; transition: 0.2s;
        }
        .action-btn-flat svg { width: 20px; height: 20px; }
        .action-btn-flat:hover { background-color: var(--reddit-hover); }

        /* --- REPLIES SECTION --- */
        .replies-section { margin-left: 12px; padding-left: 12px; border-left: 2px solid var(--reddit-border); margin-top: 10px; }
        .reply-card { display: flex; flex-direction: column; padding: 12px 0 0 0; }
        .reply-meta { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--reddit-muted); margin-bottom: 6px; }
        .reply-avatar { width: 24px; height: 24px; border-radius: 50%; object-fit: cover; }
        .reply-author { color: var(--reddit-text); font-weight: bold; }
        .reply-body { font-size: 14px; line-height: 1.4; color: var(--reddit-text); padding-left: 32px; }

        /* Reply Input */
        .reply-input-box { display: none; padding: 12px 0 0 32px; }
        .reply-input-wrapper { display: flex; gap: 8px; width: 100%; }
        .reply-input { flex: 1; background: var(--reddit-hover); border: 1px solid var(--reddit-border); color: var(--reddit-text); padding: 8px 12px; border-radius: 4px; font-size: 14px; outline: none; }
        .btn-reply { background: var(--reddit-text); color: var(--reddit-card); border: none; padding: 0 16px; border-radius: 20px; font-weight: bold; cursor: pointer; }

        /* --- SIDEBAR WIDGET --- */
        .widget { background-color: var(--reddit-card); border: 1px solid var(--reddit-border); border-radius: 4px; overflow: hidden; margin-bottom: 16px; }
        .widget-header { padding: 12px 16px; font-size: 14px; font-weight: bold; color: var(--reddit-text); border-bottom: 1px solid var(--reddit-border); display: flex; align-items: center; gap: 8px; }
        .widget-header svg { width: 18px; height: 18px; color: var(--color-amarillo); }
        .trending-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; text-decoration: none; transition: 0.2s; border-bottom: 1px solid var(--reddit-hover); }
        .trending-item:hover { background-color: var(--reddit-hover); }
        .trending-item:last-child { border-bottom: none; }
        .trending-info { display: flex; flex-direction: column; gap: 4px; }
        .trending-subreddit { font-size: 14px; font-weight: bold; color: var(--reddit-text); }
        .trending-count { font-size: 12px; color: var(--reddit-muted); }
        .trending-poster { width: 40px; height: 55px; border-radius: 4px; object-fit: cover; }

        /* ALERTS */
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 16px; font-size: 14px; font-weight: bold; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: rgba(255,208,0,0.1); color: var(--color-amarillo); border: 1px solid var(--color-amarillo); }
        .alert-error { background: rgba(255,69,0,0.1); color: var(--upvote-color); border: 1px solid var(--upvote-color); }
    </style>
</head>
<body>

    <header>
        <div class="logo"><a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Logo"></a></div>
        <nav>
            <ul>
                <li><a href="/">HOME</a></li>
                <li><a href="/#cartelera">FILMS</a></li>
                <li><a href="/community" style="color: var(--color-amarillo);">r/Community</a></li>
                @auth
                    <li>
                        <a href="/profile" title="Profile">
                            <img src="{{ asset('img/avatars/' . Auth::user()->avatar) }}" class="header-avatar" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=343536&color=D7DADC&bold=true'">
                        </a>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Log In</a></li>
                @endauth
            </ul>
        </nav>
    </header>

    <div class="layout-wrapper">
        <main class="main-feed">
            
            @if(session('status'))
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    {{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="create-post-box">
                @auth
                    <img src="{{ asset('img/avatars/' . Auth::user()->avatar) }}" class="create-post-avatar" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=343536&color=D7DADC&bold=true'">
                    <form class="create-post-form" action="{{ route('community.post') }}" method="POST">
                        @csrf
                        <textarea name="content" class="create-post-input" required placeholder="Create Post"></textarea>
                        <div class="create-post-tools">
                            <select name="movie_id" class="movie-select" required>
                                <option value="" disabled selected>Choose a community (Movie)</option>
                                @foreach($movies as $id => $movie)
                                    <option value="{{ $id }}">r/{{ Str::slug($movie['title']) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn-submit">Post</button>
                        </div>
                    </form>
                @else
                    <div style="width: 100%; text-align: center; padding: 10px; color: var(--reddit-muted);">
                        Log in to create a post and join the discussion.
                    </div>
                @endauth
            </div>

            @forelse($posts as $post)
                <div class="reddit-card">
                    <div class="vote-sidebar">
                        <button class="vote-btn upvote {{ $post['has_liked'] ? 'active' : '' }}" onclick="toggleUpvote(this, {{ $post['id'] }})">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 4l-8 8h5v8h6v-8h5z" fill="currentColor"/></svg>
                        </button>
                        <span class="vote-count {{ $post['has_liked'] ? 'active' : '' }}">{{ $post['likes'] }}</span>
                        <button class="vote-btn downvote" onclick="alert('Downvotes disabled. Let\'s keep it positive!')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 20l8-8h-5v-8h-6v8H4z" fill="currentColor"/></svg>
                        </button>
                    </div>

                    <div class="post-content">
                        <div class="post-meta">
                            @if($post['movie_info'])
                                <img src="{{ $post['movie_info']['poster'] }}" class="meta-avatar" onerror="this.src='https://via.placeholder.com/20/333/ffd000'">
                                <a href="/pelicula/{{ $post['movie_info']['id'] }}" class="subreddit">r/{{ Str::slug($post['movie_info']['title']) }}</a>
                                <span>•</span>
                            @endif
                            <span class="posted-by">Posted by u/{{ strtolower(str_replace(' ', '', $post['author'])) }}</span>
                            <span>•</span>
                            <span>{{ $post['date'] }}</span>
                        </div>

                        <div class="post-body">
                            {{ $post['content'] }}
                        </div>

                        <div class="action-bar">
                            <button class="action-btn-flat" onclick="toggleReplyBox({{ $post['id'] }})">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                {{ count($post['replies']) }} Comments
                            </button>
                            <button class="action-btn-flat" onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied!')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                                Share
                            </button>
                        </div>

                        @if(count($post['replies']) > 0 || Auth::check())
                            <div class="replies-section">
                                @auth
                                <div id="reply-box-{{ $post['id'] }}" class="reply-input-box">
                                    <form action="{{ route('community.post') }}" method="POST" class="reply-input-wrapper">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $post['id'] }}">
                                        <input type="hidden" name="movie_id" value="{{ $post['movie_id'] }}">
                                        <input type="text" name="content" required placeholder="What are your thoughts?" class="reply-input" autocomplete="off">
                                        <button type="submit" class="btn-reply">Reply</button>
                                    </form>
                                </div>
                                @endauth

                                @foreach($post['replies'] as $reply)
                                    <div class="reply-card">
                                        <div class="reply-meta">
                                            <img src="{{ $reply['avatar'] }}" class="reply-avatar" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($reply['author']) }}&background=343536&color=D7DADC'">
                                            <span class="reply-author">u/{{ strtolower(str_replace(' ', '', $reply['author'])) }}</span>
                                            <span>• {{ $reply['date'] }}</span>
                                        </div>
                                        <div class="reply-body">{{ $reply['content'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            @empty
                <div style="padding: 40px; text-align: center; color: var(--reddit-muted);">
                    No posts yet. Be the first to start a thread!
                </div>
            @endforelse

        </main>

        <aside class="sidebar">
            <div class="widget">
                <div class="widget-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    Trending Communities
                </div>
                @forelse($trendingMovies as $trending)
                    <a href="/pelicula/{{ $trending['id'] }}" class="trending-item">
                        <div class="trending-info">
                            <span class="trending-subreddit">r/{{ Str::slug($trending['title']) }}</span>
                            <span class="trending-count">{{ $trending['post_count'] }} members talking</span>
                        </div>
                        <img src="{{ $trending['poster'] }}" class="trending-poster" onerror="this.src='https://via.placeholder.com/40x55/111/333?text=Film'">
                    </a>
                @empty
                    <div style="padding: 16px; font-size: 12px; color: var(--reddit-muted);">Start posting to see trending movies!</div>
                @endforelse
            </div>
        </aside>
    </div>

    <script>
        function toggleReplyBox(id) {
            const box = document.getElementById('reply-box-' + id);
            if (box) {
                box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'flex' : 'none';
                if(box.style.display === 'flex') box.querySelector('input').focus();
            }
        }

        function toggleUpvote(buttonElement, postId) {
            if (postId === 0) return;
            
            let countSpan = buttonElement.nextElementSibling;
            let currentLikes = parseInt(countSpan.innerText) || 0;
            let isCurrentlyLiked = buttonElement.classList.contains('active');

            // Optimistic UI Update
            if (isCurrentlyLiked) {
                buttonElement.classList.remove('active');
                countSpan.classList.remove('active');
                countSpan.innerText = (currentLikes - 1) > 0 ? (currentLikes - 1) : '0';
            } else {
                buttonElement.classList.add('active');
                countSpan.classList.add('active');
                countSpan.innerText = currentLikes + 1;
            }

            // Backend Call
            fetch(`/api/community/like/${postId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    countSpan.innerText = data.likes;
                    if (data.is_liked) {
                        buttonElement.classList.add('active');
                        countSpan.classList.add('active');
                    } else {
                        buttonElement.classList.remove('active');
                        countSpan.classList.remove('active');
                    }
                } else {
                    // Revert if failed
                    if (isCurrentlyLiked) {
                        buttonElement.classList.add('active'); countSpan.classList.add('active');
                    } else {
                        buttonElement.classList.remove('active'); countSpan.classList.remove('active');
                    }
                    countSpan.innerText = currentLikes;
                }
            })
            .catch(error => console.error(error));
        }
    </script>
</body>
</html>