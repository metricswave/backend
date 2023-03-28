import React from 'react';
import ReactDOM from 'react-dom';

export default function AppWrapper() {
    return (
        <h1>Hello from React</h1>
    );
}

if (document.getElementById('app')) {
    ReactDOM.render(<AppWrapper/>, document.getElementById('app'));
}
