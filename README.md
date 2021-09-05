# Cockpit CMS Addon - Import Collection Via Api

Cockpit addon that can import collections data via API. Only accept "json" and "csv" file type.

### Disclaimer 
> Most of the code are taken from Cockpit core code [here `import.php`](https://github.com/agentejo/cockpit/blob/b0a2350b099d686b81e9c1b48fffef8845b85939/modules/Collections/Controller/Import.php#L28). 

### This is NOT an official addon of Cockpit CMS.

--------

## Installation

- Add this repo ( `import-collection` ) folder inside "addons" folder


--------

### API

- Method - `post`
- Route - `/api/import?token={your_token_goes_here}`

--------

### Parameters

| parameter  | type      | description      | 
| ---------- | --------- | ---------------- |
| entries    | file      | csv or json file |
| collection | string    | collection name, this must be the same with the collection name inside Cockpit dashboard |

--------

### Example
```javascript

    <form id="myForm">
         Import File<br>
        <input type="file" name="entries"><br><br>
         Collection Name<br>
        <input type="text" name="collection"><br>
        <button type="submit">Upload</button>
    </form>

    <script>
        const myForm = document.querySelector('#myForm');
        myForm.addEventListener("submit", e => {
            e.preventDefault();
            let data = new FormData(myForm);
            fetch('/api/import?token={your_token_goes_here}', {
                method: 'POST',
                body: data
            }).then(e => e.json()).then(res => {
                console.log(res)
            })
        })
    </script>
    
```
