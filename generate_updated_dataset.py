import pandas as pd
import numpy as np

# Parameters for dataset generation
num_records = 500
categories = [
    'Personal Care', 'Household', 'Electronics', 'Beauty', 'Clothing',
    'Food', 'Health', 'Sports', 'Outdoor', 'Home Improvement',
    'Toys', 'Books', 'Office Supplies', 'Pet Supplies', 'Jewelry'
]
brands = [
    'EcoBrand', 'PureLife', 'GreenClean', 'EcoCarry', 'SunPower', 'BioStyle',
    'Nature’s Best', 'GreenLeaf', 'SustainIt', 'EcoEssentials', 'FreshEarth', 
    'EarthWise', 'ReNew', 'EcoFlex', 'PlanetCare'
]
descriptions_list = [
    'Eco-friendly product with natural ingredients',
    'Sustainable and organic',
    'Reusable and eco-conscious',
    'Made from recycled materials',
    'Energy-efficient and green',
    'Ethically sourced and produced',
    'Low impact on the environment',
    'Made with renewable resources',
    'Certified organic and biodegradable',
    'Non-toxic and safe'
]
product_names = [
    'Eco Shampoo', 'Organic Soap', 'Bamboo Toothbrush', 'Reusable Bag', 'Solar Charger',
    'Organic Cotton Towel', 'Biodegradable Phone Case', 'Compostable Cutlery', 'Reusable Straw', 'Eco-Friendly Notebook',
    'Eco-Friendly Water Bottle', 'Natural Cleaning Products', 'Sustainable Fashion', 'Organic Skincare', 'Energy-Efficient Light Bulbs',
    'Reusable Coffee Cup', 'Organic Tea', 'Bamboo Utensil Set', 'Eco-Friendly Tote Bag', 'Solar-Powered Gadgets',
    'Biodegradable Trash Bags', 'Eco-Friendly Laundry Detergent', 'Sustainable Footwear', 'Organic Bedding', 'Eco-Friendly Packaging'
]

# Generate random data
np.random.seed(0)
product_ids = np.arange(1, num_records + 1)
product_names_list = np.random.choice(product_names, num_records)
categories_list = np.random.choice(categories, num_records)
descriptions = np.random.choice(descriptions_list, num_records)
ratings = np.random.uniform(3.5, 5.0, num_records).round(1)
eco_friendly = np.random.choice(['Yes'], num_records)  # All products are eco-friendly
prices = np.random.uniform(5.0, 50.0, num_records).round(2)
brands_list = np.random.choice(brands, num_records)

# Create DataFrame
df = pd.DataFrame({
    'product_id': product_ids,
    'product_name': product_names_list,
    'category': categories_list,
    'description': descriptions,
    'rating': ratings,
    'eco_friendly': eco_friendly,
    'price': prices,
    'brand': brands_list
})

# Save to CSV
df.to_csv('generate-updated_dataset.csv', index=False)

