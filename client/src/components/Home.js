import React, { useEffect, useState } from 'react';
import axios from 'axios';
import './Home.css';

const Home = () => {
    const [posts, setPosts] = useState([]);

    useEffect(() => {
        axios.get('http://localhost/server/api/posts.php')
            .then(response => setPosts(response.data.records))
            .catch(error => console.error('Error fetching posts:', error));
    }, []);

    return (
        <div className="home">
            <h1>Home</h1>
            <ul>
                {posts.map(post => (
                    <li key={post.id}>
                        <p>{post.content}</p>
                        <p><strong>Category:</strong> {post.category}</p>
                        <p><strong>Author:</strong> {post.author}</p>
                        <p><strong>Posted at:</strong> {post.created_at}</p>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default Home;
