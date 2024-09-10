import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.neighbors import NearestNeighbors
import joblib

# Step 2: Load Your Dataset
df = pd.read_csv('generate-updated_dataset.csv')

# Step 3: Combine Features into a Single String
df['combined_features'] = df['product_name'] + ' ' + df['category'] + ' ' + df['description'] + ' ' + df['brand']

# Add category and price_range to features (converted to strings)
df['features_for_vectorizer'] = df['combined_features'] + ' ' + df['category'] + ' ' + df['price'].astype(str)

# Step 4: Vectorize the Combined Features
tfidf = TfidfVectorizer(stop_words='english')
tfidf_matrix = tfidf.fit_transform(df['features_for_vectorizer'])

# Step 5: Train the Nearest Neighbors Model
knn = NearestNeighbors(n_neighbors=5, algorithm='auto')
knn.fit(tfidf_matrix)

# Step 6: Save the Trained Model and Vectorizer
joblib.dump(knn, 'product_recommendation_model.pkl')
joblib.dump(tfidf, 'tfidf_vectorizer.pkl')

print("Model and vectorizer have been saved successfully!")