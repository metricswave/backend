import * as ReactDOMClient from 'react-dom/client';

function AppWrapper({callback}) {
    return (
        <div ref={callback}>
            <h1>Hello World</h1>
        </div>
    );
}

const rootElement = document.getElementById("app");

const root = ReactDOMClient.createRoot(rootElement);
root.render(<AppWrapper callback={() => {
    // This callback is called after the component is mounted
}}/>);
