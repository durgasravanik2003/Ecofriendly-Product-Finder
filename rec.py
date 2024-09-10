from flask import Flask, request, jsonify
import pandas as pd
import joblib

app = Flask(__name__)

# Load the model and vectorizer
model = joblib.load('product_recommendation_model.pkl')
vectorizer = joblib.load('tfidf_vectorizer.pkl')

# Load the dataset
df = pd.read_csv('generate-updated_dataset.csv')

@app.route('/recommend', methods=['POST'])
def recommend():
    data = request.json
    product_name = data['product_name']
    category = data['category']
    description = data['description']
    brand = data['brand']
    price = data['price']

    # Combine input features
    combined_features = f"{product_name} {category} {description} {brand} {category} {price}"
    features_vector = vectorizer.transform([combined_features])

    # Get recommendations
    distances, indices = model.kneighbors(features_vector)
    recommendations = df.iloc[indices[0]]

    result = recommendations[['product_name', 'category', 'description', 'brand', 'price']].to_dict(orient='records')
    return jsonify(result)

@app.route('/')
def index():
    return app.send_static_file('index.html')

if __name__ == '__main__':
    app.run(debug=True)
    print("Initiating")