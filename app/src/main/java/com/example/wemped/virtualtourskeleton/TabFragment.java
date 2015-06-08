package com.example.wemped.virtualtourskeleton;

import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AbsListView;
import android.widget.ArrayAdapter;
import android.widget.GridView;
import android.widget.RelativeLayout;

import java.util.ArrayList;

import mehdi.sakout.fancybuttons.FancyButton;

/**
 * Created by wemped on 5/7/15.
 */

/*Fragment that each floor tab will contain*/

public class TabFragment extends Fragment{
    private String tabName = null;
    private int tabId = 0;
    private int mapId = 0;
    private int numCols = 0;
    ArrayList<Stop> stops = null;
    GridView gridView;


    @Override
    public void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        this.mapId = getArguments().getInt("TAB_MAP_ID");
        this.tabId = getArguments().getInt("TAB_ID");
        this.tabName = getArguments().getString("TAB_ITEM_NAME");
        this.stops = Globals.getStopsWithMapId(this.mapId);
    }

    @Override
    public View onCreateView(LayoutInflater infalter, ViewGroup container, Bundle savedInstanceState){
        //RelativeLayout mainTabLayout = new RelativeLayout(getActivity());
        //RelativeLayout.LayoutParams mainParams = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.MATCH_PARENT, RelativeLayout.LayoutParams.MATCH_PARENT);
        //mainTabLayout.setLayoutParams(mainParams);

        this.gridView = new GridView(getActivity());

        //mainTabLayout.addView(this.gridView);

        //THIS IS NEEDED IF THE ITEMS IN THE GRID ARE NOT CLICKABLE IN NATURE (ex. textviews are not clickable but buttons are)
        /*this.gridView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                //Create intent to stopActivity
                //go to intent
                Intent stopIntent = new Intent(getActivity(),StopActivity.class);
                stopIntent.putExtra("STOP_ID",view.getTag().toString());
                Log.v("onClick",view.getTag().toString());
                startActivity(stopIntent);
            }
        });*/

        int numStops = this.stops.size();
        if (numStops > 4){
            this.numCols = 3;
            this.gridView.setNumColumns(3);
            gridView.setPadding(50,50,50,50);
        } else {
            this.numCols = 1;
            this.gridView.setNumColumns(1);
            gridView.setPadding(150,50,150,50);
        }

        //this.gridView.setNumColumns(3);
        //gridView.setBackgroundColor(Color.parseColor("#0083d6"));
        //ViewGroup.LayoutParams gridParams = new ViewGroup.LayoutParams(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.MATCH_PARENT);
        //gridParams.setMargins(10,10,10,10);
        //gridView.setLayoutParams(gridParams);
        //this.gridView.setStretchMode(GridView.STRETCH_COLUMN_WIDTH);
        //return mainTabLayout;
        //gridView.setPadding(50,50,50,50);
        return gridView;
    }


    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
        StopListAdapter adapter = new StopListAdapter(getActivity(),this.stops);
        //setListAdapter(adapter);
        this.gridView.setAdapter(adapter);
        gridView.setHorizontalSpacing(50);
        gridView.setVerticalSpacing(50);
        gridView.setGravity(Gravity.CENTER);
    }


    public int getMapId(){
        return this.mapId;
    }
    public String getTabName(){return this.tabName;}

    /*This adapter and its corresponding xml layouts will be where we can edit
     and design our Stop buttons and their arrangement*/
    public class StopListAdapter extends ArrayAdapter<Stop>{

        /*public StopListAdapter(Context context, ArrayList<Stop> stops){
            super(context,0,stops);
        }

        @Override
        public View getView(int position,View convertView,ViewGroup parent){

        }*/
        public StopListAdapter(Context context, ArrayList<Stop> stops){
            super(context,0,stops);
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent){
            Stop stop = getItem(position);
            if(convertView==null){
                convertView=LayoutInflater.from(getContext()).inflate(R.layout.stop_list_item,parent,false);
            }

            FancyButton stopButton = (FancyButton)convertView.findViewById(R.id.stop_button);
            stopButton.setText(stop.getStopName());
            stopButton.setBackgroundColor(Color.parseColor("#003f87"));
            stopButton.setFocusBackgroundColor(Color.parseColor("#0083d6"));
            stopButton.setTextSize(20);
            stopButton.setRadius(15);
            stopButton.setTag(stop.getStopID());
            stopButton.setCustomTextFont("avenir-light.ttf");
            stopButton.setOnClickListener(new View.OnClickListener() {

                @Override
                public void onClick(View view) {
                    Intent stopIntent = new Intent(getActivity(),StopActivity.class);
                    stopIntent.putExtra("STOP_ID",Integer.valueOf(view.getTag().toString()));
                    Log.v("NEWonClick",view.getTag().toString());
                    startActivity(stopIntent);
                }
            });
            stopButton.setMinimumWidth(parent.getWidth());
            return convertView;
        }
    }

}
