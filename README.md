# Cockpit addon - Import Collections Via Api

Cockpit addon that can import collections data via API. Only accept "json" and "csv" file type.

### Disclamier 
> Most of the code are taken from Cockpit core code [here `import.php`](https://github.com/agentejo/cockpit/blob/b0a2350b099d686b81e9c1b48fffef8845b85939/modules/Collections/Controller/Import.php#L28). 

### This is NOT an official addon of Cockpit CMS.

--------

## Installation

- Add `import-collections` folder inside "addons" folder
- Make sure to rename the folder name as `import-collections`


--------

### API

- Method - `post`
- Route - `/api/import?token={your_token_goes_here}`

--------

### Parameters

| param      | type      |
| ---------- | --------- |
| entries    | file      |
| collection | text      |

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
