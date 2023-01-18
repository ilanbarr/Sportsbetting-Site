from flask import Flask, render_template, url_for

# initalize app
app = Flask(__name__)

#flask routes
@app.route('/')
def base():
    return render_template("login.html", title="Login")

if __name__ == '__main__':
    app.run(debug=True)

